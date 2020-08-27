<?PHP
ini_set('memory_limit', '-1');
include 'condb.php';

$getQuery = mysqli_query($conn,"SELECT * FROM `itemurl` WHERE `checked` = 0");

while($row = mysqli_fetch_assoc($getQuery)){

    //Get Product Details
    $url= $row['url'];
    $html=file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    // Get title
    $getTitle=$xpath->query("//div[@class='headwrap']/h1");
    $title = $getTitle[0]->textContent;
    // Get price
    $getPrice = $xpath->query("//span[@class='price']");
    $price = $getPrice[0]->textContent;
    // Get ProductDescription
    $getEdition = $xpath->query("//div[@class='productdescription']/p");
    $node_counts = $getEdition->length;
    // Get PriceInfo (determines whether insert this record into DB or not)
    $boolprice = false;
    $getPriceInfo = $xpath->query("//span[@class='priceinfo']");
    if($getPriceInfo->length >= 1){
        $priceinfo = $getPriceInfo[0]->textContent;
        if(strlen($priceinfo) > 0){
            $getpriceinfo = strstr($priceinfo, 'This item failed');
            if(strlen($getpriceinfo) > 0){
                $boolprice = true;
            }
        }

    }else{
        $boolprice = false;
    }

    $edition = "";
    $age = "";
    $casktype = "";
    $strength = "";
    $size = "";

    for ($x = 0; $x < $node_counts; $x++) {
        //get edition
        $getedition = strstr($getEdition[$x]->textContent, 'Edition');
        if(strlen($getedition) > 0){
            $edition = substr($getedition, 8);
        }
        //get age
        $getage = strstr($getEdition[$x]->textContent, 'Age:');
        if(strlen($getage) > 0){
            $age = substr($getage, 4);
        }
        //get casktype
        $getcasktype = strstr($getEdition[$x]->textContent, 'Cask Type:');
        if(strlen($getcasktype) > 0){
            $casktype = substr($getcasktype, 10);
        }

        $cond = strstr($getEdition[$x]->textContent, 'ABV', true);
        if(strlen($cond) > 0){
            $strength = strstr($getEdition[$x]->textContent, '/', true);
            $size = strstr($getEdition[$x]->textContent, '/', false);
            $size = substr($size, 2);
        }

    }

    // Get ProductDescription
    $getsoldon = $xpath->query("//div[@class='lotno lotfeatured']");
    $soldon = strstr($getsoldon[0]->textContent, ' – ', false);
    $soldon = substr($soldon,4);

    // Get Image Url
    $anchors = $dom -> getElementsByTagName('img');
    //    foreach ($anchors as $element) {
    //        $src = $element -> getAttribute('src');
    //        //echo $src;
    //    }
    $image = $anchors->item(0)->getAttribute('src');

    //    $getproductimg = $xpath->query("//img[@id='productimg]");
    //    $productimg =  $getproductimg->item(0)->getAttribute('src');
    //    echo $productimg;

    //Newly added : For getting note text

    $noteinfo_txt ="";
    $nodelist = $xpath->query("//div[@class='productdescription']/p/em");
    $note_counts = $nodelist->length;
    if($note_counts >= 1){
        $note_text = $nodelist[0]->textContent;
        if(strlen($note_text) > 0){
            $getnoteinfo = strstr($note_text, 'Please note');
            if(strlen($getnoteinfo) > 0){
                $noteinfo_txt = $note_text;
                //get noteinfo text:
                $notedetailinfo = "";
                $nodelist = $xpath->query("//div[@class='productdescription']/p/strong");
                $notedetail_counts = $nodelist->length;
                if($notedetail_counts >= 1){
                    $notedetail_text = $nodelist[0]->textContent;
                    if(strlen($notedetail_text) > 0){
                        $notedetailinfo = $notedetail_text;
                        $noteinfo_txt = $noteinfo_txt." : ".$notedetailinfo;
                    }
                }
            }
        }
    }else{
        $noteinfo_txt = "";
    }

    if ($boolprice == false){
        echo $title, $price, $edition, $age, $casktype, $strength, $size, $soldon, $image, $url, $noteinfo_txt;
        mysqli_query($conn,"INSERT INTO `aproduct` (`id`, `title`, `price`, `edition`, `age`, `casktype`, `strength`, `size`, `soldon`, `image`, `url`, `noteinfo`) VALUES (NULL, '".$title."', '".$price."', '".$edition."', '".$age."', '".$casktype."', '".$strength."', '".$size."', '".$soldon."', '".$image."', '".$url."', '".$noteinfo_txt."');");
        $id = $row['id'];
        mysqli_query($conn,"UPDATE `itemurl` SET `checked` = '1' WHERE `itemurl`.`id` = ".$id.";");
    }else{
        echo "Insert Skipped!";
    }

    sleep(0);
}

