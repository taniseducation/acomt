    </div>
    <div id="opdracht">
      <?php
      if (strlen($titel)<20) {
        $titel=$titel.' <a href="index.php" style="margin-top: 0px;">&#8962;</a>';
      }
      echo $titel;
      ?>
    </div>
  </body>
</html>