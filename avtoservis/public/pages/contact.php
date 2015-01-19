<?php 
  if(isset($_POST['send']))
  {
    extract($_POST);

    $header = "From: ".$ime." (".$email.")";

    if(!@mail("igor@yahoo.com","Контакт",$poraka,$header))
    {
      message("Грешка при испраќање на порака","danger");
    }
    else
    {
       message("Пораката е успешно испратена","success");
    }
  }
?>

<h1>Контакт</h1>
<hr/>
<div class="levo">
  <div class="kontakt">
    <form action="" method="POST">
      <div class="grupa">
        <input type="text" name="ime" placeholder="Внеси име" required>
      </div>
      <div class="grupa">
        <input type="email" name="email" placeholder="Внеси емаил" required>
      </div>
      <div class="grupa">
        <textarea cols="50" rows="10" name="poraka" placeholder="Внеси содржина" required></textarea>
      </div>
      <div class="grupa">
        <input type="submit" value="Испрати" id="isprati_email" name="send">
      </div>
    </form>
  </div>
</div>
<div class="desno">

</div>
