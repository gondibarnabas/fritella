<?



require_once("db_config.php");
require_once("language.php");
require_once("create_db.php");
global $language;

function systemid_to_systemtype($id)
{

    $query = ("SELECT system_type FROM systems WHERE system_id = '$id'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $text = $result['system_type'];

    }
    return $text;
}


function id_to_username($id)
{

    $query = ("SELECT full_name FROM m_users WHERE id = '$id'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $text = $result['full_name'];

    }
    return $text;
}


function id_to_systemId($id)
{

    $query = ("SELECT system_id FROM systems WHERE id = '$id'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $text = $result['system_id'];

    }
    return $text;
}

function userpic($id)
{
    $eredmeny = "./images/no_image.jpg";
    $query = ("SELECT * FROM pictures WHERE userid = '$id' and foldername ='user' ");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $picfolder = $result['picfolder'];
        $picturename = $result['picturename'];
        $picextension = $result['picextension'];

        $eredmeny = '';
        $eredmeny = '' . $picfolder . '/thumbs85/' . $picturename;
    }
    return $eredmeny;


}


function groupname_to_picture($username)
{
    //require_once("./function/db_config.php");
    $query = ("SELECT picid FROM m_group WHERE nickname = '$username'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $id = $result['picid'];

    }
    return $id;
}

function userid_to_pass($userid)
{
    require_once("./function/db_config.php");
    $query = ("SELECT pass FROM user WHERE id = '$userid'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $id = $result['pass'];

    }
    return $id;
}

function username_to_email($username)
{
    require_once("./function/db_config.php");
    $query = ("SELECT email FROM m_users WHERE nickname = '$username'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $id = $result['email'];

    }
    return $id;
}


function grouppic($id)
{
    $eredmeny = "./images/no_image.jpg";
    $query = ("SELECT * FROM pictures WHERE userid = '$id' and foldername ='group' ");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $picfolder = $result['picfolder'];
        $picturename = $result['picturename'];
        $picextension = $result['picextension'];

        $eredmeny = '';
        $eredmeny = '' . $picfolder . '/thumbs85/' . $picturename;
    }
    return $eredmeny;


}

function stamp_to_time($timestamp, $language)
{
    if ($language == "hun") {
        $res = date('Y.m.d', $timestamp);
    }
    if ($language == "eng") {
        $res = date('d/m/Y', $timestamp);
    }
    return $res;
}


function groupname_to_id($username)
{
    $id = "";

    $query = ("SELECT * FROM m_gruop WHERE nickname = '$username'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $id = $result['id'];

    }
    return $id;
}


function ido($timestampa, $language)
{
    global $language;

    $now_timestamp = date('U');
    $ma = date("d", $now_timestampa);
    $nap = date("d", $timestampa);
    $honap_ma = date("m", $now_timestampa);
    $honap_nap = date("m", $timestampa);
    $hour = (int)date('H', $timestampa); // $hour is now (int)16
    $minute = date('i', $timestampa); // $minute is now (int)23

    if ($language == "hun") {
        if ($nap == $ma and $honap_ma == $honap_nap) {
            $res = $hour . ":" . $minute;
        } else {
            $res = date("Y/m/d", $timestampa);
        }
    }
    if ($language == "eng") {
        if ($nap == $ma) {
            $res = $hour . ":" . $minute;
        } else {
            $res = date("d/m/Y", $timestampa);
        }
    }

    return $res;

}


function id_to_groupname($idx)
{

    $r = '';
    $result = '';
    $queryx = "select nickname  from m_group where id = '$idx' ";
    $row = mysql_query($queryx);

    while ($result = mysql_fetch_array($row)) {
        $r = $result['nickname'];

    }
    return $r;
}


function id_to_fullgroupname($idx)
{

    $r = '';
    $result = '';
    $queryx = "select full_name  from m_group where id = '$idx' ";
    $row = mysql_query($queryx);

    while ($result = mysql_fetch_array($row)) {
        $r = $result['full_name'];

    }
    return $r;
}

function lastlogin_setup($id)
{
    $idobejeg = date('U');


    $query = "update m_users set lastlogin ='$idobejeg' where id='$id' ";

    $res = mysql_query($query);
}

function username_to_id($username)
{
    $id = "";

    $query = ("SELECT * FROM m_gruop WHERE nickname = '$username'");
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $id = $result['id'];

    }
    return $id;


}


function userid_to_superuser($useridx)
{
    $x = $useridx;
    $query = "SELECT flag FROM m_user WHERE id='$x' ";
    $row = mysql_query($query);

    while ($result = mysql_fetch_array($row)) {
        $res = $result['flag'];

    }
    if ($res == "superuser") {
        $_SESSION['user_right'] = 'superuser';
    }
    if ($res == "user") {
        $_SESSION['user_right'] = 'user';
    }

}


function language_fillup()
{
    $query = "DROP TABLE language";
    $res = mysql_query($query);
    $eredmeny = "";
    create_lang_table();


    $query = "SELECT * FROM language ";
    $res = mysql_query($query);
    if (mysql_num_rows($res) == 0) {
        $query = "INSERT INTO language (name,name_eng,name_esp,name_ger,name_hun,name_ita,name_lax,name_lay,pic, flag,pos,index1,comm) ";
        $query .= " VALUES ";

        $handle = fopen("data/lang.csv", "r");

        // loop content of csv file, using comma as delemiter
        while (($data = fgetcsv($handle, 1024, ",")) !== false) {
//$id = (int) $data[0];
            $name = ($data[0]);
            $name_eng = ($data[1]);
            $name_esp = ($data[2]);
            $name_ger = ($data[3]);
            $name_hun = ($data[4]);
            $name_ita = ($data[5]);
            $name_lax = ($data[6]);
            $name_lay = ($data[7]);
            $pic = ($data[8]);
            $flag = ($data[9]);
            $pos = ($data[10]);
            $index1 = ($data[11]);
//$comm = ($data[12]);
            $comm = "xxx";
            $query .= "('$name','$name_eng','$name_esp','$name_ger','$name_hun','$name_ita','$name_lax','$name_lay','$pic','$flag','$pos','$index1','$comm' ), ";
        }

        fclose($handle);

        $query .= "('name_last','name_eng','name_esp','name_ger','name_hun','name_ita','x','y','pic','flag','pos','index2','comm')";

        $res = mysql_query($query);
        if (!($res)) {
            $mysql_err = mysql_error();
            $eredmeny = "<br> Feltoltes hiba: $mysql_err";
            error_log($mysql_error);
        }


        return $eredmeny;


    }
}

function machine_to_item()
{
    $inventories = array();
    $sql = "SELECT DISTINCT device_id, country_id FROM m_machine where flag = '1'";
    $qry = mysql_query($sql);

    while ($machine = mysql_fetch_array($qry)) {
        $counter_flag = 0;
        $sum_flag = 0;

        $sql = "SELECT * FROM inventory_" . $machine['device_id'];
        $qry2 = mysql_query($sql);

        $item = array();

        while ($row = mysql_fetch_array($qry2)) {
            $counter_flag += $row['counter_flag'];
            $sum_flag += $row['sum_flag'];
            $item = $row;
        }

        $item['counter_flag'] = $counter_flag;
        $item['sum_flag'] = $sum_flag;
        array_push($inventories, array('machine' => $machine, 'item' => $item));
    }

    return $inventories;
}

?>
