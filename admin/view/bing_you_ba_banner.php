<script type="text/javascript">
{literal}
function checkPriority(obj) {
  if (isNaN(obj.value)) {
    alert('请输入数字(1~10000)');
    return false;
  }
  var v = Number(obj.value);
  if (v < 1 
      || v > 10000) {
    alert('请输入数字(1~10000)');
    return false;
  }
  return true;
}
function submitBaValidate($new_one)
{
  if (!checkPriority(document.getElementById("priority")))
    return false;
  if ($new_one == 1
      && document.getElementById("image").value.length == 0) {
    alert('请上传图标!');
    return false;
  }
  return true;
}
{/literal}
</script>
<div style="margin:35px 130px 0 130px;">
  <div class="input_form">
    <form action={if $new_one eq 1}"view/add_bing_you_ba_banner.php"{else}"view/bing_you_ba_banner.php"{/if} method="post" enctype="multipart/form-data" onsubmit="return submitBaValidate({$new_one})">
      <table>
        <tr><td><input type='hidden' name='id' value='{if isset($id)}{$id}{/if}'/></td></tr>
        <tr>
          <td class="form_label">优先级</td>
          <td><input style="width:100px;padding-left:2px;" id='priority' type='number' min='1' max='10000' name='priority' value='{if isset($priority)}{$priority}{else}1{/if}' onchange='checkPriority(this)'/><p class='must_p' style='font-size:13px;'>1~10000 (数值越小优先级越高)</p></td>
        </tr>
        <tr>
          <td class="form_label">图片</td>
          <td class="upload"><input style='font-size:10px;color:#C00;' name='txt1' type="text" disabled="disabled" value='不能超2M (限定格式：jpg,png)'/><input type="button" value="浏览"/><input type="file" id='image' name='image' onchange="txt1.value=this.value;"/></td>
        {if !empty($img_url)}
          <td style="padding-left:10px;"><a href='{$img_url}' target='_blank'><img src='{$img_url}' height="60" width="60"</img></a></td>
        {/if}
        </tr>
      </table>
      <hr style="margin-top:20px;height:1px;border:0;background-color:#FF9900;"/>
      <div class="submit">
        <input style="width:80px;margin-right:40px;" type='submit' value={if $new_one eq 1}'提交'{else}'修改'{/if}/>
        <input style="width:80px;" type='reset' value='取消' />
      </div>
    </form>
  </div>
</div>
