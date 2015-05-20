<?php

require_once APP_ROOT . '/common/cc_key_def.php';

class group_chat
{
  private static $org_name = 'zhongweiyikang';
  private static $app_name = 'didikuaiyi';
  private static $org_admin = 'ddky';
  private static $client_id = 'YXA68RZFoP3JEeScgrvhsQpAKw';
  private static $client_secret = 'YXA6wGpt6MNe0XIHi0Z-il17Hi5nQjo';

  private static $url_prefix = "https://a1.easemob.com/zhongweiyikang/didikuaiyi/";

  public static function get_token()
  {
    $ck = CK_EASEMOB_TOKEN;
    $cc = new cache();
    $result = $cc->get($ck);
    if ($result !== false) {
      return $result;
    }

    $data['grant_type'] = 'client_credentials';
    $data['client_id']  = self::$client_id;
    $data['client_secret']  = self::$client_secret;
    $result = util::post_data(self::$url_prefix . 'token', json_encode($data));
    if (empty($result)
        && empty($result['access_token'])) {
      return false;
    }

    $result = json_decode($result);
    $tv = (int)$result['expires_in'];
    $token = $result['access_token'];
    $cc->setex($ck, $tv, $token);
    return $token;
  }

  public static add_group($groupname,
                          $desc,
                          $public,
                          $approval,
                          $owner)
  {
    $url = self::$url_prefix . "chatgroups/" . $group_id;
    $token = self::get_token();
    $header[] = 'Authorization: Bearer ' . $token;
    $ret = util::get_data($url . "?"
                          . "groupname=" . $groupname
                          . "&desc=" . $desc
                          . "&public=" . $public
                          . "&approval=" . $approval
                          . "&owner=" . $owner,
                          $header
                          );

  }
};
