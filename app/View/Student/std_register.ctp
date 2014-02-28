<script>
    var checkEmail =0;
    var checkUsername =0;
</script>
<?php
echo $this->Html->script('jquery-1.4.4.min.js');
$this->Html->script('project_list', array('inline' => false));
echo $this->Form->create('User', array('autoComplete' => 'off','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false , 'div' => false, )));
?>
<div
	id="register"><!--            <div id="profile">   --> <!--                <h3 class="title">学生のプロファイinputル</h3>-->
<!--                <div id="fullname" class='info'>--> <!--                    <b>名前 :</b> <br>-->
<!--                    <input type="text" name="data[User][full_name]" placeholder="名前.."
  </div> 
  >--> <?php 
  echo $this->Form->input('fullname', array(
                    					'type' => 'text',
                   						'required' => false));

  ?>

<div id="birthday" class='info date'><b>誕生日:</b> <br>
  <?php
  echo $this->Form->input('birthday', array(
                    					'type' => 'date',
										'dateFormat' => 'DMY',
										'timeFormat' => null,
										'minYear' => date('Y') - 70,
                   						'label' => false,
										'maxYear' => date('Y') - 0));
  ?></div>
<div id="username" class='info'><b>ユーザ名:</b> <img id="username_thongbao"
	width="20" height="20" style="display: none; border: 0px"><br>
<input type="text" name="data[User][username]" value=""
	placeholder="ユーザ名"></div>
<div id="password" class='info'><b>パスワード:</b> <br>
<input type="password" name="data[User][password]" value=""
	placeholder='パスワード..'></div>
<div id="retype_password" class='info'><b>確認パスワード :</b><br>
<input type="password" name="data[User][retype_password]" value=""
	placeholder="確認パスワード.."></div>
<div id="retype_password" class='info'><b>初期パスワード :</b><br>
<input type="password" name="data[User][primary_password]" value=""
	placeholder="初期パスワード.."></div>
<div id="email" class='info'><b>メール :</b><br>
<input type="text" name="data[User][email]" placeholder="メール..."></div>
<div id="address" class='info'><b>アドレス:</b><br>
<input type="text" name="data[User][address]" placeholder="アドレス..."></div>
<div id="phone" class='info'><b>電話番号:</b><br>
<input name="data[User][phone]" type="text" placeholder="電話番号..."></div>
<!--               <div id="question" class='info'>--> <!--                    <b>セキュリティー問題:</b><br>-->
<!--                    <input type="text" name="data[User][question]" placeholder="セキュリティー問題...">-->
<!--                </div>--> <!--                 <div id="answer" class='info'>-->
<!--                    <b>セキュリティー答え:</b><br>--> <!--                    <input type="text" name="data[User][answer]" placeholder="セキュリティー答え...">-->
<!--                </div>-->
<div id="creditcard" class='info'><b>クレジットカード:</b><br>
<input type="text" name="data[User][credit_number]"
	placeholder="クレジットカード..."></div>
<div id="profile_img" class='info'><b>アバター:</b><br>
<input type="file" name="data[User][profile_img]"></div>
</div>
<br>
  <?php
  echo $this->Form->submit('Submit');
  echo $this->Form->end();?>

</div>
