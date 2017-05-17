    <? include ('header.php') ?>
    <!-- <div id="allmap"></div> -->
    <div id="container"></div>
    <div class="search_box">
        <form method="post">
            <div>输入搜索的内容:</div><input type="text" id="search" name="topic" autocomplete="off" placeholder="请输入序号，地址，或名称查询">
        </form>
        <ul class="search_results"></ul>
    </div>

    <? include ('config/conn.php') ?>
    <?php
        $strsql="select * from myMap" ;
        $result = $conn->query($strsql);

        // 获取查询结果
        $arr_point = '[';
        $maker = '';
        $addverlay='';
        $ops = '';
        $infoWindow='';
        $addEventListener='';
        $i = 0;
        // $addverlay = ''; //修改php.ini的error_reporting = E_ALL为error_reporting = E_ALL & ~E_NOTICE

        while ($row = $result->fetch_assoc()) {
            $img = '';

            //1.从数据库中获取坐标，创建地图上的坐标点，并把它放到数组里
            $arr_point .= 'new BMap.Point('.$row["point"].'),';
            //print_r($row);
            //echo '</br>';
            //print_r($arr_point);
            //echo '</br>';
            //print_r($row["point"]);
            //echo '</br>';
            //2.利用这些坐标点创建标注mark1-mark9,将标注都存放到变量$mark中
            //$maker .= 'var marker'.$i.' = new BMap.Marker('.$row["point"].');';
            $maker .= 'var marker'.$i.' = new BMap.Marker(point['.$i.']);';
            //print_r($maker);
            //echo '</br>';
            //print_r(point[$i]);
            //echo '</br>';
            //3.将标注添加到地图中
            $addverlay .= 'map.addOverlay(marker'.$i.');';
            //print_r($addverlay);
            //echo '</br>';
            for($m = 0;$m < $row["level"];$m++)
            {
                $img .= "<img src='http://cdn2.iconfinder.com/data/icons/diagona/icon/16/031.png' />";
            }

            //4.信息窗口的标题，记住，要先定义opts，再定义信息窗口
            $ops .= 'var opts'.$i.' = {title : \'<span style="font-size:14px;color:#0A8021">'.$row['title'].'</span>\'};';
            //print_r($ops);
            //echo '</br>';

            //5.创建信息窗口对象，信息窗口接收两个参数，第一个并指信息窗口的内容，第二个指上面定义的opts. 信息窗口里支持任意的htm代码
            $infoWindow .= "var infoWindow".$i." = new BMap.InfoWindow(\"<div style='line-height:1.8em;font-size:12px;'><b>地址:</b>".$row['address']."</br><b>电话:</b>010-59921010</br><b>口碑：</b>".$img."<a style='text-decoration:none;color:#2679BA;float:right' href='#'>详情>></a></div>\", opts".$i.");";
            //print_r($infoWindow);
            //echo '</br>';

            //6.给每一个标注添加mouseover事件
            $addEventListener .= 'marker'.$i.'.addEventListener("mouseover", function(){this.openInfoWindow(infoWindow'.$i.');});';
            //print_r($addEventListener);
            //echo '</br>';
            $i++;
        }
        $arr_point .= substr($arr_point , 0 , -1).']]';
      ?>
      <script type="text/javascript">
          var map = new BMap.Map("container");    // 创建Map实例
          var point = new BMap.Point(116.404, 39.915);    //创建中心点坐标
          map.centerAndZoom(point, 40);    //初始化地图,设置中心点坐标和地图级别

          function openMyWin(id,p){
              map.openInfoWindow(id,p);
          }
      </script>

      <!-- 定义好信息后，需要把js用php语句拼起来 -->
      <?php
          echo '<script> var point = '.$arr_point.';';    //坐标点
          echo $maker;                                   //创建标注
          echo $addverlay;                             //将标注添加到地图中
          echo 'map.setViewport(point); ';           // 调整地图的最佳视野为显示标注数组point
          echo $ops;
          echo $infoWindow ;
          echo $addEventListener.' </script> '
      ?>

       <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
       
       <script type="text/javascript" src="js/index.js"></script>
    </body>
 </html>
