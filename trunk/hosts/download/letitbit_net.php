<?php

if (!defined('RAPIDLEECH'))
{
    require_once("index.html");
    exit;
}

class letitbit_net extends DownloadClass {
     public function Download($link) {
         global $premium_acc;
            if ( ($_REQUEST ["premium_acc"] == "on" && $_REQUEST ["premium_pass"]) || ($_REQUEST ["premium_acc"] == "on" && $premium_acc ["letitbit_net"] ["pass"] ) ) {
		$this->DownloadPremium($link);
            } else {
                $this->DownloadFree($link);
            }
	}

    private function DownloadFree($link) {
        global $Referer;

            $page = $this->GetPage($link);
            is_present($page, "File not found", "The requested file was not found");
            is_present($page, "Gesuchte Datei wurde nicht gefunden", "The requested file was not found");
            is_present($page, "������������� ���� �� ������", "The requested file was not found");
            $cookie = GetCookies($page);
            $Urlact = "http://letitbit.net".cut_str ( $page, 'id="ifree_form" action="' ,'" ');
            $uid5 = cut_str($page, 'name="uid5" value="','"');
            $uid = cut_str($page, 'name="uid" value="','"');
            $name = cut_str($page, 'name="name" value="','"');
            $pin = cut_str($page, 'name="pin" value="','"');
            $realuid = cut_str($page, 'name="realuid" value="','"');
            $realname = cut_str($page, 'name="realname" value="','"');
            $host = cut_str($page, 'name="host" value="','"');
            $ssserver = cut_str($page, 'name="ssserver" value="','"');
            $sssize = cut_str($page, 'name="sssize" value="','"');
            $lsarrserverra = cut_str($page, 'name="lsarrserverra" value="','"');
            $dir = cut_str($page, 'name="dir" value="','"');
            $optiondir = cut_str($page, 'name="optiondir" value="','"');
            $pin_wm = cut_str($page, 'name="pin_wm" value="','"');
            $md5crypt = cut_str($page, 'name="md5crypt" value="','"');
            $realuid_free = cut_str($page, 'name="realuid_free" value="','"');
            $post = array ();
            $post['uid5'] = $uid5;
            $post['uid'] = $uid;
            $post['name'] = $name;
            $post['pin'] = $pin;
            $post['realuid'] = $realuid;
            $post['realname'] = $realname;
            $post['host'] = $host;
            $post['ssserver'] = $ssserver;
            $post['sssize'] = $sssize;
            $post['dir'] = $dir;
            $post['optiondir'] = $optiondir;
            $post['lsarrserverra']= $lsarrserverra;
            $post['pin_wm']= $pin_wm;
            $post['md5crypt'] = $md5crypt;
            $post['realuid_free'] = $realuid_free;
            $post['pin_wm_tarif'] = "default";
            $post['submit_way_selection2'] = "Regular download";
            $Url = parse_url($Urlact);
            $page = $this->GetPage($Urlact, $cookie, $post, $link);
            $t=explode(";", GetCookies($page));
            $cookie .=";". $t[0].";".$t[2];
            preg_match('%<form action="(.*)" method="post" id="dvifree">%', $page, $UT);
            $Urlact = $UT[1];
            $ac_http_referer = cut_str($page, 'name="ac_http_referer" value="','"');
            $rand = cut_str($page, 'name="rand" value="','"');
            unset($post);
            $post['uid5'] = $uid5;
            $post['uid'] = $uid;
            $post['name'] = $name;
            $post['pin'] = $pin;
            $post['realuid'] = $realuid;
            $post['realname'] = $realname;
            $post['host'] = $host;
            $post['ssserver'] = $ssserver;
            $post['sssize'] = $sssize;
            $post['dir'] = "";
            $post['optiondir'] = "";
            $post['lsarrserverra'] = $lsarrserverra;
            $post['pin_wm'] = $pin_wm;
            $post['md5crypt'] = $md5crypt;
            $post['realuid_free'] = $realuid_free;
            $post['pin_wm_tarif'] = "default";
            $post['submit_way_selection2'] = "Regular download";
            $post['ac_http_referer'] = $ac_http_referer;
            $post['links_sent'] = "1";
            $post['rand'] = $rand;
            $Url = parse_url($Urlact);
            $page = $this->GetPage($Urlact, $cookie, $post, $link);
            if(preg_match ( '%Wait for Your turn: <br/><span id="seconds" style="font-size:18px">(.*)</span>%', $page, $wait )){
                $this->CountDown($wait[1]);
            } else {
                preg_match ( '/seconds = ([0-9]+);/', $page, $wait);
                $this->CountDown($wait[1]);
            }
            preg_match("/ajax_check_url = '(.+)';/", $page, $temp);
            $tlink = $temp[1];
            $Url = parse_url($tlink);
            $page = $this->GetPage($tlink, $cookie, $post, $link);
            if (!preg_match('/http:(.*)/', $page, $dlink)) {
                html_error ( "The file is temporarily unavailable for download. Please try a little bit later");
            }
            $dwn = urldecode(trim($dlink[0]));
            $Url = parse_url($dwn);
            $Filename = basename ($Url['path']);
            $this->RedirectDownload($dwn, $Filename, $cookie, 0, $tlink, $Filename);
            exit();
    }
    
    private function DownloadPremium($link) {
        global $premium_acc;

            $page = $this->GetPage($link);
            is_present($page, "File not found", "The requested file was not found");
            is_present($page, "Gesuchte Datei wurde nicht gefunden", "The requested file was not found");
            is_present($page, "������������� ���� �� ������", "The requested file was not found");
            $cookie = GetCookies($page);

            $post = array();
            $post['way_selection'] = "1";
            $post['submit_way_selection1'] = "HIGH Speed Download";
            $page = $this->GetPage($link, $cookie, $post, $link);
            $Urlact = "http://letitbit.net".cut_str ( $page ,'<form action="' ,'"' ); //I REALLY HATE THIS PART
            $Url = parse_url($Urlact);
            $uid5 = cut_str($page, 'name="uid5" value="','"');
            $uid = cut_str($page, 'name="uid" value="','"');
            $name = cut_str($page, 'name="name" value="','"');
            $pin = cut_str($page, 'name="pin" value="','"');
            $realuid = cut_str($page, 'name="realuid" value="','"');
            $realname = cut_str($page, 'name="realname" value="','"');
            $host = cut_str($page, 'name="host" value="','"');
            $ssserver = cut_str($page, 'name="ssserver" value="','"');
            $sssize = cut_str($page, 'name="sssize" value="','"');
            $lsarrserverra = cut_str($page, 'name="lsarrserverra" value="','"');
            $pin_wm = cut_str($page, 'name="pin_wm" value="','"');
            $md5crypt = cut_str($page, 'name="md5crypt" value="','"');
            $realuid_free = cut_str($page, 'name="realuid_free" value="','"');
            $pass = $_REQUEST["premium_pass"] ? trim($_REQUEST["premium_pass"]) : $premium_acc ["letitbit_net"] ["pass"];
            unset($post);
            $post['uid5'] = $uid5;
            $post['uid'] = $uid;
            $post['name'] = $name;
            $post['pin'] = $pin;
            $post['realuid'] = $realuid;
            $post['realname'] = $realname;
            $post['host'] = $host;
            $post['ssserver'] = $ssserver;
            $post['sssize'] = $sssize;
            $post['dir'] = "";
            $post['optiondir'] = "";
            $post['lsarrserverra'] = $lsarrserverra;
            $post['pin_wm'] = $pin_wm;
            $post['md5crypt'] = $md5crypt;
            $post['realuid_free'] = $realuid_free;
            $post['pin_wm_tarif'] = "default";
            $post['pass'] = $pass;
            $post['submit_paypal'] = "Download file";
            $page = $this->GetPage($Urlact, $cookie, $post, $link);
            $t=explode(";", GetCookies($page));
            $cookie .=";". $t[0].";".$t[2];
            $preform = cut_str($page, '<iframe', '</iframe>');
            if (!$preform) {
                html_error("Error : Please check ur premium code");
            }
            $tlink = cut_str($preform, 'src="','"');
            $page = $this->GetPage($tlink, $cookie, 0, $Urlact);
            if (!preg_match('%href="(.*)" style="font-size:16px; text-align:center;"%', $page, $dl)) {
                html_error("Error: Download link not found!");
            }
            $dlink = urldecode(trim($dl[1]));
            $Url = parse_url($dlink);
            $FileName = basename($Url['path']);
            $this->RedirectDownload($dlink, $FileName, $cookie, 0, $tlink, $FileName);
            exit();
    }
}

/*************************\
 WRITTEN BY VinhNhaTrang 15-11-2010
 Fix the premium code by code by vdhdevil
 Fix the free download code by vdhdevil & Ruud v.Tony 25-3-2011
 Updated the premium code by Ruud v.Tony 19-5-2011
\*************************/
?>