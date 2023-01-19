<?php
session_start();
include('functions.php');
check_session_id();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>入手カード入力画面</title>
</head>

<body>
  <form action="cardlist_create.php" method="POST">
    <fieldset>
      <legend>入手カード入力画面</legend>
      <a href="index.php">一覧画面</a>
      <div>
        series: <input type="text" name="series">
      </div>
      <div>
        number: <input type="text" name="number">
      </div>
      <div>
        rarelity: <input type="text" name="rarelity">
      </div>
      <div>
        name: <input type="text" name="name">
      </div>
      <div>
        price: <input type="text" name="price">
      </div>
      <div>
        amount: <input type="text" name="amount">
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>