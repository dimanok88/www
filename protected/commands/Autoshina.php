<?php
class AutoshinaCommand extends CConsoleCommand
{
    public function run($args)
    {
        Yii::import('application.vendors.*');
        require_once('Zend/Dom/Query.php');

        $link_param = array(
            '0'=>'100200020',
            '1'=>'200000020',
            '2'=>'400000020',
        );

        foreach($link_param as $link_p){
            $page= array('0'=>'1');

            $obj = CurlAuth::init() ->login('http://www.autoshinavrn.ru/index.php')->load('http://www.autoshinavrn.ru/setuser.php?user=romachu');
            $result =  $obj->load('http://www.autoshinavrn.ru/viewpage.php?page_id=1&parms='.$link_p.'1')->content;
            //echo $result;

            $dom = new Zend_Dom_Query($result);
            $result_page = $dom->query('//table.spacer//th//a.side');

            foreach($result_page as $p)
            {
               if(is_numeric($p->nodeValue))
                   $page[] = $p->nodeValue;
            }

            $ar = array();
            $mas2 = array();
            foreach($page as $p_n){
                if($p_n > 3) break;
                $result =  $obj->load('http://www.autoshinavrn.ru/viewpage.php?page_id=1&parms='.$link_p.$p_n)->content;
                $dom = new Zend_Dom_Query($result);
                $results = $dom->query('//table.tbl-border/tr');

                $i = 0;
                foreach ($results as $res) {
                    if(($i != 0 && $i != 1) && $i != count($results)-1 && $i != count($results)-2){
                        $k = 0;
                       foreach($res->childNodes as $ch)
                       {
                           if($k == 0 || $k == 2 || $k == 4){
                               $string = rtrim(preg_replace('/\\s+$/i','', $ch->nodeValue));
                               if($k == 0){
                                   $s = trim(preg_replace('/\(Остаток.*$/i','',str_replace(" «фото»", "", $string)));
                                   $t = preg_replace('!\pZ+$!i', '', urlencode($s));
                                   $t = str_replace('%C2%A0', '',$t);
                                   $t = urldecode($t);
                                   //$t = iconv('UTF-8','WINDOWS-1251', $t);
                                   //$t =  trim(mb_convert_encoding($t, 'koi8-r', 'utf-8'));
                                   preg_match_all("!(.*)\s+(.*?)$!i", trim($t), $r);
                                   $ar[$p_n][$i][$k] = $r[1][0];
                                   $ar[$p_n][$i]['country'] = $r[2][0];
                               }
                               elseif($k==2)
                               {
                                   $ar[$p_n][$i][$k] = str_replace(' ', '',preg_replace('/\(.*$/i','', $string));
                               }
                               else $ar[$p_n][$i][$k] = trim($string);
                           }
                           $k++;
                       }
                    }
                    $i++;
                }
                $mas2 = array_merge($ar[$p_n], $mas2);
                sleep(4);
            }

            $new_str = "\"string\";\"country\";\"price\";\"type\";\"season\";\"shipi\";\"filepic\";\"type_item\";\"ostatok\";\r\n";
            foreach($mas2 as $str)
            {
                $new_str .= "\"".$str[0]."\";\"".$str['country']."\";\"".$str[2]."\";;;;;;\"".$str[4]."\";\r\n";
            }

            $name = '';
            if($link_p == '100200020') $name = 'tire';
            elseif($link_p == '200000020') $name = 'disc';
            elseif($link_p == '400000020') $name = 'gruz';

            file_put_contents('./resources/excel/'.date('Y.m.d').'_'.$name.'.csv', $new_str);
        }

    }
}