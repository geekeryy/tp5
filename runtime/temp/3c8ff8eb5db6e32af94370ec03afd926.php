<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:93:"H:\Git\phpproject\thinkphp_5.0.10_full\public/../application/index\view\index\showCourse.html";i:1504618658;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title>课表</title>
</head>
<body>
姓名：
<?php echo $vo1['name']; ?>
<br>
学院专业：
<?php echo $vo1['college']; ?>
<?php echo $vo1['major']; ?>
<br>
学号
<?php echo $vo1['student_id']; ?>
<br>
班级
<?php echo $vo1['classes']; ?>
<br>
<br>
	

<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<?php echo $vo['year']; ?>学年，
第
<?php echo $vo['semester']; ?>学期
<br>
<?php echo $vo['id']; ?>
:

<?php echo $vo['course']; ?>
<br>
<?php echo $vo['type']; ?>
<br>

<?php echo $vo['time']; ?>
<br>
<?php echo $vo['classroom']; ?>
<br>
<?php echo $vo['teacher']; ?>
<br>
<br>


<?php endforeach; endif; else: echo "" ;endif; ?>
</body>
</html>