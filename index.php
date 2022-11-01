<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="#">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>萬年曆作業</title>
  <style>
    /*請在這裹撰寫你的CSS*/
    * {
      box-sizing: border-box;
    }

    .main-background {
      background-color: #bfbfbf;
    }

    .container {
      width: 80%;
      border: 1px solid black;
      height: 800px
    }

    .left-character {
      height: 600px;
      width: 30%;
      margin-top: 100px;
      margin-right: 40px;
      border: 1px solid black;
    }

    .right-calendar {
      height: 600px;
      width: 60%;
      margin-top: 100px;
      border: 1px solid black;
    }

    .row {
      justify-content: center;
    }

    .nextmonth,
    .premonth {
      text-decoration: none;
    }

    .premonth:hover,
    .nextmonth:hover {
      color: burlywood;
    }


    .calendar {
      /* margin-left: 40px; */
      text-align: center;
    }
    .week-footer{
      display:flex;
      flex-wrap: wrap;
      width:80%;
      margin: auto;
    }
    .week-footer .date{
      border:1px solid black;
      width:calc(100% / 7);
      margin-left:-1px;
      margin-top:-1px;
    }
    .week-footer .date:hover{
      transform: scale(1.05);
      background-color: lightcyan;
    }
    .holiday{
      background-color: pink;
    }
    .week-header{      
      display:flex;
      width:80%;
      margin: auto;
      margin:0 auto
    }
    .header,.header-holiday{
      display: flex;
      width:calc(100% / 7);
      justify-content: center;
      border: 1px solid black;
      margin-left: -1px;
    }
    .header-holiday{
      background-color: #ff3333;
    }
    .time{
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
      margin-bottom: 20px;
    }
    .picture{

    }

  </style>
</head>

<body class="main-background">
  <?php
  /*請在這裹撰寫你的萬年曆程式碼*/
  $cal = [];
  $holiday=['2022-10-25'=>"光復節","2022-10-10"=>"國慶日"];
  $month = (isset($_GET['m'])) ? $_GET['m'] : date("n");
  $year = (isset($_GET['y'])) ? $_GET['y'] : date("Y");

  $nextMonth = $month + 1;
  $preMonth = $month - 1;
  $nextYear = $year;
  $preYear = $year;

  if ($nextMonth == 13) {
    $nextMonth = 1;
    $nextYear = $year + 1;
  }
  if ($preMonth == 0) {
    $preMonth = 12;
    $preYear = $year - 1;
  }

  $firstDay = $year . "-" . $month . "-1";
  $firstDayWeek = date("w", strtotime($firstDay));
  $monthDays = date("t", strtotime($firstDay));
  $lastday = $year . "-" . $month . "-" . $monthDays;
  $spaceDays = $firstDayWeek;
  // 日 一 二 三 四 五 六
  // spaceDays代表空白天數 例如 今天星期六  前面有6天
  $weeks = ceil(($monthDays + $spaceDays) / 7);
  // weeks 算出這個月有幾周
  // ceil函式 => 無條件進位
  $lastspaceday = (7 * $weeks) - $monthDays;
  // $lastspaceday 代表本該月份最後一天距離周末的天數
  for ($i = 0; $i < $spaceDays; $i++) {
    $cal[] = '';
  }
  for ($i = 0; $i < $monthDays; $i++) {
    $cal[] = date("j", strtotime("$i days", strtotime($firstDay)));
  }
  for ($i = 0; $i < ($lastspaceday- $spaceDays); $i++) {
    $cal[] = '';
  }


  ?>
  <h1>萬年曆</h1>

  <div class="container">
    <div class="row">
      <div class="col-4  rounded-4 left-character">
        角色
      </div>
      <div class="col-8 rounded-4 right-calendar">
        <div class="calendar">
          <div class="time">
            <a href="?y=<?= $preYear; ?>&m=<?= $preMonth; ?>" class="premonth">
              <i class="fa-solid fa-arrow-left"></i>
              上一個月
            </a>

            <h1><?= $year; ?> 年 <?= $month; ?> 月份</h1>

            <a href="?y=<?= $nextYear; ?>&m=<?= $nextMonth; ?>" class="nextmonth">下一個月
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </div>
          
            
          <div class="week-header">
              <div class="header-holiday">日</div>
              <div class="header">一</div>
              <div class="header">二</div>
              <div class="header">三</div>
              <div class="header">四</div>
              <div class="header">五</div>
              <div class="header-holiday">六</div>
          </div>
              <div class="week-footer">
              <?php
              foreach ($cal as $i => $day) {
                if($day!=""){
                  $show=explode("-",$day)[0];
                }else{
                  $show="";
                }
                if(array_key_exists($day,$holiday)){

                  echo "<div class='date holiday'>";
                  echo $show;
                  echo "<div>{$holiday[$day]}</div>";
                  echo "</div>";
              }else{
          
                  echo "<div class='date'>$show</div>";
              }
          }
                          
              ?>
            </div>
            <br>
            <div class="picture">
          <img src="./zerodamage1.png" alt="" style="max-width: 745px ;max-height:300px;">
          </div>
        </div>

      </div>
    </div>




</body>

</html>