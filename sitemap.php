<?php
require_once("../includes/configuration.php");
    // Set the output file name.
    $file = "../sitemap.xml";
    
    // Set the start URL. Here is https used, use http:// for 
    // non SSL websites.
    $url = $website_fulllink;
                                        
    // Set true or false to define how the script is used.
    // true:  As CLI script.
    // false: As Website script.
    @define (CLI, false);

    // Define here the URLs to skip. All URLs that start with 
    // the defined URL will be skipped too.
    // Example: "https://www.plop.at/print" will also skip
    // https://www.plop.at/print/bootmanager.html
    $skip = array (
                    "$website_fulllink"."signin",
                    "$website_fulllink"."javascript",
                    "$website_fulllink"."imaker/.."
                  );
    
    // Define what file types should be scanned.
    $extension = array (
                         ".html", 
                         ".php"
                       );

    // Scan frequency
    $freq = "daily";
    
    // Page priority
    $priority = "0.5";
    
    // Init end ==========================

    
function Path ($p)
{
    $a   = explode ("/", $p);
    $len = strlen ($a[count ($a) - 1]);
    return (substr ($p, 0, strlen ($p) - $len));
}

function GetUrl ($url)
{
    $agent = "Mozilla/5.0 (compatible; Plop PHP XML Sitemap Generator/" . VERSION . ")";

    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_USERAGENT, $agent);

    $data = curl_exec($ch);

    curl_close($ch);

    return $data;
}

function GetQuotedUrl ($str)
{
    if ($str[0] != '"') return $str; // Only process a string 
                                     // starting with double quote
    $ret = "";
    
    $len = strlen ($str);    
    for ($i = 1; $i < $len; $i++) // Start with 1 to skip first quote
    {
        if ($str[$i] == '"') break; // End quote reached
        $ret .= $str[$i];
    }
    
    return $ret;
}

function Scan ($url)
{
    global $scanned, $pf, $extension, $skip, $freq, $priority;
    
    echo $url . NL;

    array_push ($scanned, $url);
    $html = GetUrl ($url);
    $a1   = explode ("<a", $html);

    foreach ($a1 as $val)
    {
        $anker_parts = explode (">", $val);
        $a = $anker_parts[0];
        
        $href_split  = explode ("href=", $a);
        $href_string = $href_split[1];
        
        if ($href_string[0] == '"')
        {
            $next_url = GetQuotedUrl ($href_string);
        }
        else
        {
            $spaces_split = explode (" ", $href_string);
            $next_url     = str_replace ("\"", "", $spaces_split[0]);
        }

        $fragment_split = explode ("#", $next_url);
        $next_url       = $fragment_split[0];
        
        if ((substr ($next_url, 0, 7) != "http://")  && 
            (substr ($next_url, 0, 8) != "https://") &&
            (substr ($next_url, 0, 6) != "ftp://")   &&
            (substr ($next_url, 0, 7) != "mailto:"))
        {
            if ($next_url[0] == '/')
            {
                $next_url = "$scanned[0]$next_url";
            }
            else
            {
                $next_url = Path ($url) . $next_url;
            }
        }
        
        if (substr ($next_url, 0, strlen ($scanned[0])) == $scanned[0])
        {
            $ignore = false;
            if (isset ($skip))
            {
                foreach ($skip as $v)
                {
                    if (substr ($next_url, 0, strlen ($v)) == $v)
                    {
                        $ignore = true;
                    }
                }
            }
            
            if (!$ignore && !in_array ($next_url, $scanned))
            {
                /*foreach ($extension as $ext)
                {
                    if (strpos ($next_url, $ext) > 0)
                    {*/
                        fwrite ($pf, "  <url>\n" .
                                     "    <loc>" . htmlentities ($next_url) ."</loc>\n" .
                                     "    <changefreq>$freq</changefreq>\n" .
                                     "    <priority>$priority</priority>\n" .
                                     "  </url>\n");
                        Scan ($next_url);
                    /*}
                }*/
            }
        }
    }
}

    @define (VERSION, "1.0");                                            
    @define (NL, CLI ? "\n" : "<br>");
    

    $pf = fopen ($file, "w");
    if (!$pf)
    {
        echo "Cannot create $file!" . NL;
        return;
    }

    fwrite ($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
                 "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n" .
                 "        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
                 "        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n" .
                 "        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n" .
                 "  <url>\n" .
                 "    <loc>$url/</loc>\n" .
                 "    <changefreq>daily</changefreq>\n" .
                 "  </url>\n");

    $scanned = array();
    Scan ($url);
    
    fwrite ($pf, "</urlset>\n");
    fclose ($pf);

    echo "Done." . NL;
    echo "$file created." . NL;
?>