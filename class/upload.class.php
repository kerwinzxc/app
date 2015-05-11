<?php

class upload
{
  private $file_field;
  private $save_dir;
  private $file_name;
  private $full_file_name;
  private $max_size;
  private $allow_types = array();

  private $err_info = array(
                            "OK",
                            "文件大小超出 upload_max_filesize 限制",
                            "文件大小超出 MAX_FILE_SIZE 限制",
                            "文件未被完整上传",
                            "没有文件被上传",
                            "上传文件为空",
                            "PARAM" => "POST数据格式错误",
                            "POST" => "文件大小超出 post_max_size 限制",
                            "SIZE" => "文件大小超出网站限制",
                            "TYPE" => "不允许的文件类型",
                            "DIR"  => "目录创建失败",
                            "IO"   => "输入输出错误",
                            "UNKNOWN" => "未知错误",
                            "MOVE" => "文件保存时出错",
                            "DIR_ERROR" => "创建目录失败",
                           );
  private $err_desc = '';

  function __construct($field,
                       $save_dir,
                       $max_size,
                       $allow_types // array
                      )
  {
    $this->file_field = $field;
    $this->save_dir = $save_dir;
    $this->max_size = $max_size;
    $this->allow_types = $allow_types;
  }
  private function get_err($err)
  {
    if (!array_key_exists($err, $this->err_info)) {
      $err = 'UNKNOWN';
    }
    return $this->err_info[$err];
  }

  //=
  public function error()
  {
    return $this->err_desc;
  }
  public function filename()
  {
    return $this->file_name;
  }
  public function full_filename()
  {
    return $this->full_file_name;
  }
  public function just_do_it()
  {
    if (empty($this->file_field)) {
      $this->err_desc = $this->get_err("PARAM");
      return false;
    }
    if ($this->file_field['error']) {
      $this->err_desc = $this->get_err($this->file_field['error']);
      return false;
    }
    if ($this->file_field['size'] > $this->max_size) {
      $this->err_desc = $this->get_err('SIZE');
      return false;
    }
    if (!is_uploaded_file($this->file_field['tmp_name'])) {
      $this->err_desc = $this->get_err('UNKNOWN');
      return false;
    }
    $ext = strtolower(strrchr($this->file_field["name"], '.'));
    if (!in_array($ext, $this->allow_types)) {
      $this->err_desc = $this->get_err('TYPE');
      return false;
    }
    if (!file_exists($this->save_dir)) {
      if (!mkdir($this->save_dir, 0777, true)) {
        $this->err_desc = $this->get_err('DIR_ERROR');
        return false;
      }
    }

    $this->file_name = md5(microtime(true) . mt_rand(1, 9999999)) . $ext;
    $this->full_file_name = $this->save_dir . "/" . $this->file_name;
    if (!move_uploaded_file($this->file_field['tmp_name'],
                            $this->full_file_name)) {
      $this->err_desc = $this->get_err('MOVE');
      return false;
    }
    return true;
  }
};
