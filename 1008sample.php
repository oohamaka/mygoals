<?php
var_dump($_POST);
?>

<!DOCTYPE html>

<head></head>

  <ul>
    <li>
      <input type="checkbox" form="bulk-archive">
      項目1
      <input type="button" value="アーカイブ">
      <form style="display: inline" method='post'>
        <select>
          <option value="" selected disabled>削除理由を選択…</option>
          <option value="1">理由1</option>
          <option value="1">理由2</option>
        </select>
        <input type="submit" value="削除">
      </form>
    </li>

    <li>
      <input type="checkbox" form="bulk-archive">
      項目2
      <input type="button" value="アーカイブ">
      <form style="display: inline" method='post'>
        <select>
          <option value="" selected disabled>削除理由を選択…</option>
          <option value="1">理由1</option>
          <option value="1">理由2</option>
        </select>
        <input type="submit" value="削除">
      </form>
    </li>

    <li>
      <input type="checkbox" form="bulk-archive">
      項目3
      <input type="button" value="アーカイブ">
      <form style="display: inline" method='post'>
        <select>
          <option value="" selected disabled>削除理由を選択…</option>
          <option value="1">理由1</option>
          <option value="1">理由2</option>
        </select>
        <input type="submit" value="削除">
      </form>
    </li>
  </ul>

<form>
  <input id="bulk-archive" type="submit" value="チェックボックスをつけたものをまとめてアーカイブ">
</form>