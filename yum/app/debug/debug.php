<?php
declare(strict_types=1);

error_reporting(E_ALL); // raportuje wszystkie błędy jakie pojawiły się w kodzie
ini_set('display_errors', "1");   

class DebugTools
{
    public static function tagsOpen(string $background, ?string $comment, ?string $type) : string
    {
        return "<debug style=\"
        z-index:10000;
        position:relative;
        display:block;
        font-family: Segoe UI, Helvetica;
        font-size:13px;
        letter-spacing:0.4px;
        color:#342D59;
        clear:both;
        $background 
        padding:9px 15px;
        font-weight:bold;
        line-height: 19px;
        border: 1px solid #76c1a0;
        \"><small style=\"float:right; opacity:0.8;margin-bottom:10px; color:#8E0084;\">$type</small><inf style=\"border-bottom:1px solid #63D2E8; display:inline-block\">$comment</inf>
    <pre style=\"margin-top:4px;margin-bottom:03px;\">";
    }

    public static function tagsClose() : string 
    {
        return '</pre>
        </debug>';
    }

    public static function setBackground (bool $important) : string 
    {
        return $important ? "background: #f11c69; color:white;" : "background:#94F2C8;";
    }

    public static function backtrace(array $backtrace, bool $large_backtrace = false) : string
    {
        //$where = debug_backtrace(limit:1);
        $file =  $backtrace[0]["file"];
        $line = $backtrace[0]["line"];

       

        if($large_backtrace) {

            $html = '<strong>backtrace</strong>'; 
            foreach ($backtrace as $case) {
                $file =  $case["file"];
                $line = $case["line"];
                $html .= "<div style='clear:both; display:block; margin-bottom:2px; margin-top:2px; margin-left:20px;'>$file $line</div>";
            }
            return $html;
        } else {
           return "<small style='float:right; font-size:9.5px; clear:both; opacity: 1; color:#8E0084; font-weight:600'> $file $line</small>"; 
        }
    }


}


/**
 * Nicely formatted var_dump output
 */
function debug( $data, ?string $comment = null, bool $important = false, bool $backtrace = false) : void
{
    $type = "var_dump";
    $where = debug_backtrace(limit:1);
    $background = DebugTools::setBackground($important);
    echo DebugTools::tagsOpen($background, $comment, $type);
    echo DebugTools::backtrace($where);
    var_dump($data);
    echo DebugTools::tagsClose();

    if($backtrace) {
    $show_history = debug_backtrace(limit:5);
    echo "<pre>";
    //print_r(debug_backtrace(limit:3));
    echo DebugTools::backtrace($show_history, true);
    echo "</pre>"; 
    }

}


/**
 * Nicely formatted print_r output
 */
function dump( $data, ?string $comment = null, bool $important = false, bool $backtrace = false ) : void
{  
    $type = "print_r";
    $where = debug_backtrace(limit:1);
    $background = DebugTools::setBackground($important);
    echo DebugTools::tagsOpen($background, $comment, $type);
    echo DebugTools::backtrace($where);
    print_r($data);
    echo DebugTools::tagsClose();

    if($backtrace) {
    $show_history = debug_backtrace(limit:5);
    echo "<pre>";
    //print_r(debug_backtrace(limit:3));
    echo DebugTools::backtrace($show_history, true);
    echo "</pre>"; 
    }
}


function dumpdie( $data, ?string $comment = null, bool $important = false, bool $backtrace = false ) : void 
{
    dump($data,$comment,$important,$backtrace); exit; //TODO: FIX BACKTRACE PROBLEM
}

function debugdie( $data, ?string $comment = null, bool $important = false, bool $backtrace = false ) : void 
{
    debug($data,$comment,$important,$backtrace); exit; //TODO: FIX BACKTRACE PROBLEM
}

