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
      margin-top: -30px;
      background: url('./picture/UwU.png') no-repeat;
      backdrop-filter: blur(5px);
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .container {
      margin-top: 150px;
      width: 1440px;
      border: 1px solid black;
      height: 700px;
    }

    .calendar-base {
      height: 620px;
      width: 60%;
      border: 1px solid black;
      margin-top: 38px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.40);
    }

    .container-clock {
      margin-top: 50px;
      text-align: center;
      border: 3px solid #ffcc00;
      color: #b38f00;
      border-radius: 40px;
      transition: 0.5s;
    }

    .container-clock:hover {
      background-color: #e6b800;
      color: black;
      box-shadow: 0 0 30px #e6b800;
    }

    .ZDalliance {
      margin-top: 50px;
      margin-bottom: 10px;
      margin-left: 30px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .ZDpicture {
      margin-top: -100px;
    }
    .ZDicon{
      width: inherit;
      margin-left: 130px;
      margin-top: 35px;
      box-shadow: 10px 10px 3px #ff0080;
    }

    .row {
      justify-content: center;
    }

    .nextmonth,
    .premonth {
      text-decoration: none;
    }

    a {
      color: black;
    }

    .premonth:hover,
    .nextmonth:hover,
    .todayBtn:hover {
      color: burlywood;
    }


    .calendar {
      margin-top: 35px;
      text-align: center;
    }

    .time {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      align-items: center;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .time h1 {
      width: 100%;
    }

    .week-header {
      display: flex;
      width: 80%;
      margin: 0 auto;
    }

    .header,
    .header-holiday {
      display: flex;
      width: calc(100% / 7);
      justify-content: center;
      margin-bottom: 20px;
    }

    .header-holiday {
      background-color: #ff8533;
      border-radius: 10px;
    }

    .week-footer {
      display: flex;
      flex-wrap: wrap;
      width: 80%;
      margin: auto;
    }

    .week-footer .date {
      height: 70px;
      width: 70px;
      width: calc(100% / 7);
      border-radius: 10px;
      overflow:auto;
    }

    .week-footer .date:hover {
      transform: scale(1.2);
      background-color: lightcyan;
      border-radius: 10px;
    }

    .holiday {
      background-color: pink;
    }

    .today {
      background-color: #80ffbf;
    }

    .todayBtn {
      text-decoration: none;
    }
  </style>
</head>

<body class="main-background" onload="startTime()">
  <?php
  /*請在這裹撰寫你的萬年曆程式碼*/
  $cal = [];
  $month = (isset($_GET['m'])) ? $_GET['m'] : date("n");
  $year = (isset($_GET['y'])) ? $_GET['y'] : date("Y");
  $holiday = [
    "2014-04-25" => "夢幻之星 Online 2台服公測",
    "2017-04-25" => "夢幻之星 Online 2台服結束營運",
    "2020-08-5" => "夢幻之星 Online 2國際服開始營運",
    "2021-06-9" => "PSO2 NGS大型內容更新",
    "2021-07-29" => "加入公會ZeroDamage",
    "2022-07-9" => "開始打CM3任務",
    "2022-07-16" => "角色大整形",
    "$year-01-1" => "元旦",
    "$year-02-28" => "和平紀念日",
    "$year-04-4" => "兒童節",
    "$year-10-25" => "光復節",
    "$year-10-10" => "國慶日"
  ];
  $today = date("Y-n-j");

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
  $nextmonthfirstDay = $year . "-" . $month + 1 . "-1";
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
    $cal[] = date("Y-m-j", strtotime("$i days", strtotime($firstDay)));
  }
  for ($i = 0; $i < ($lastspaceday - $spaceDays); $i++) {
    $cal[] = '';
  }
  ?>
  <div class="container">
    <div class="row">
      <div class="col-8 rounded-4 calendar-base">

        <div class="calendar">
          <div class="time">

            <h1><?= $year; ?> 年 <?= $month; ?> 月</h1>

            <a href="?y=<?= $preYear; ?>&m=<?= $preMonth; ?>" class="premonth">
              <i class="fa-solid fa-arrow-left"></i>
              上一個月
            </a>

            <a href="?d=<?= $today; ?>" class="todayBtn">
              <i class="fa-solid fa-calendar-day"></i>
              今日

            </a>

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
              if ($day != "") {
                $show = explode("-", $day)[2];
              } else {
                $show = "";
              }
              if ($day == $today) {
                echo "<div class='date today'>";
                echo $show;
                if (array_key_exists($day, $holiday)) {
                  echo "<div>{$holiday[$day]}</div>";
                }
                echo "</div>";
              } else {
                if (array_key_exists($day, $holiday)) {
                  echo "<div class='date holiday'>";
                  echo $show;
                  echo "<div>{$holiday[$day]}</div>";
                  echo "</div>";
                } else {
                  echo "<div class='date'>$show</div>";
                }
              }
            }
            ?>
          </div>
        </div>

      </div>
      <!-- 圖片 -->
      <div class="col-4 ZDalliance">
        <!-- 時鐘 -->
        <div class="container-clock">
          <div class="clock-datetime">
            <div class="clock-time">
              <span id="hour">00</span>:
              <span id="minutes">00</span>:
              <span id="seconds">00</span>
              <span id="period">AM</span>
            </div>
          </div>
          <div class="date">
            <span id="year">year</span>年 -
            <span id="month">月</span> -
            <span id="daynumber">00</span>日&nbsp;
            <span id="dayname">星期</span>
          </div>
        </div>

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active" style="margin-top:150px;">
              <img src="./picture/ZD01.png" class=" w-100 ZDpicture" alt="...">
            </div>
            <div class="carousel-item" style="margin-top:150px;">
              <img src="./picture/ZD02.png" class=" w-100 ZDpicture" alt="...">
            </div>
            <div class="carousel-item" style="margin-top:150px;">
              <img src="./picture/ZD03.png" class=" w-100 ZDpicture" alt="...">
            </div>
            <div class="carousel-item" style="margin-top:150px;">
              <img src="./picture/ZD04.png" class=" w-100 ZDpicture" alt="...">
            </div>
            <div class="carousel-item" style="margin-top:150px;">
              <img src="./picture/ZD05.png" class=" w-100 ZDpicture" alt="...">
            </div>
            <div class="carousel-item" style="margin-top:150px;">
              <img src="./picture/ZD06.png" class=" w-100 ZDpicture" alt="...">
            </div>
            <div class="carousel-item" style="margin-top:150px;">
              <img src="./picture/ZD07.png" class=" w-100 ZDpicture" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="margin-top:60px;"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="margin-top:60px;"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <img src="./picture/ZD.png" alt="" class="ZDicon">
      </div>
    </div>

    <script src="./script.js"></script>
</body>

</html>