<?PHP
include 'condb.php';


//Get Items From Page

$url="https://www.scotchwhiskyauctions.com/auctions/";
$html=file_get_contents($url);
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
foreach ($xpath->query("//a[@class='prodbox']/@href") as $href){
    $itemurl = $href->textContent;

    if($itemurl == NULL){

    }else{
        $midurl = "https://www.scotchwhiskyauctions.com/".$itemurl;
        insertfulurl($midurl);
        //mysqli_query($conn,"INSERT INTO `itemurl` (`id`, `url`, `checked`) VALUES (NULL, '".$fullurl."', '0');");
    }
}
foreach ($xpath->query("//a[@class='prodbox finalbox']/@href") as $href){
    $itemurl = $href->textContent;

    if($itemurl == NULL){

    }else{
        $midurl = "https://www.scotchwhiskyauctions.com/".$itemurl;
        insertfulurl($midurl);
        //mysqli_query($conn,"INSERT INTO `itemurl` (`id`, `url`, `checked`) VALUES (NULL, '".$fullurl."', '0');");
    }
}

sleep(1);

function insertfulurl($urlparam) {
    //connect to MySQL Database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "parsermine";

    // Create connection
    $conn = new mysqli($hostname, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        echo "DB Connected!";
    }
    /* select db */
    mysqli_select_db($conn, $db);

    //Get Product fulurls
    $url= $urlparam;
    $html=file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);

    $nodelist = $xpath->query("//div[@class='productsubcats products']/a/@href");
    $goods_counts = $nodelist->length; // count how many nodes returned
    echo $goods_counts;

    $nodelist = $xpath->query("//div[@class='pages']/a/@href");
    $page_counts = $nodelist->length / 2; // count how many nodes returned
    echo $page_counts;

    for ($count = 1; $count <= $page_counts; $count++) {

        $itemurl = $url."?page=".$count."&area=";
        //echo $itemurl;
        $htmlnode = file_get_contents($itemurl);
        $domnode = new DOMDocument();
        libxml_use_internal_errors(true);
        $domnode->loadHTML($htmlnode);
        $xpath = new DOMXPath($domnode);

        $listprod = $xpath->query("//a[@class='prodbox']/@href");
        $prod_counts = $listprod->length; // count how many nodes returned

        $listfinal = $xpath->query("//a[@class='prodbox finalbox']/@href");
        $final_counts = $listfinal->length; // count how many nodes returned

        $node_counts = $prod_counts + $final_counts;
        echo $node_counts;

        foreach ($xpath->query("//a[@class='prodbox']/@href") as $href){
            $itemurl = $href->textContent;

            if($itemurl == NULL){

            }else{
                $fullurl = "https://www.scotchwhiskyauctions.com/".$itemurl;
                echo $fullurl;
                //insertdata($fullurl);
                mysqli_query($conn,"INSERT INTO `itemurl` (`id`, `url`, `checked`) VALUES (NULL, '".$fullurl."', '0');");
            }
        }

        foreach ($xpath->query("//a[@class='prodbox finalbox']/@href") as $href){
            $itemurl = $href->textContent;

            if($itemurl == NULL){

            }else{
                $fullurl = "https://www.scotchwhiskyauctions.com/".$itemurl;
                echo $fullurl;
                //insertdata($fullurl);
                mysqli_query($conn,"INSERT INTO `itemurl` (`id`, `url`, `checked`) VALUES (NULL, '".$fullurl."', '0');");
            }
        }
    }

    sleep(1);
}