<?php
namespace Home\Controller;

use Think\Controller;

/**
 * 招新报名网站后台管理类
 *
 * @author    LiLei <417608793@qq.com>
 * @copyright eeYes.net
 */
class IndexController extends Controller
{
    /**
     * 输出报名第一弹页面
     */
    public function index()
    {
        $this->display('department');
    }

    /**
     * 表单数据处理
     * 获取表单数据
     * 返回json数据
     * 状态码与消息对应表
     * 200 --- 保存数据成功
     * 201 --- 没过数据验证
     * 202 --- 写入数据库异常
     * 203 --- 同一ip提交申请过多（10次）
     * 204 --- 没获取到用户ip
     * 205 --- 该生已提交报名申请
     */
    public function data()
    {
        if (true) {
            // 保存返回数据的值
            $returnData = array();
            // 部门代码-名称映射数组
            $department = array(
                '1' => '市场部',
                '2' => '项目部',
                '3' => '新闻部',
                '4' => '影视部',
                '5' => '新媒体部',
                '6' => '前端美工组',
                '7' => '后台web组',
                '8' => '后台app组',
                '9' => '蓝鲸',
                '10' => '公关部',
            );
            // 获取数据
            $data['name'] = I('post.name/s');
            $data['sex'] = I('post.sex/s');
            $data['native_place'] = I('post.native_place/s');
            $data['academy'] = I('post.academy/s');
            $data['class'] = I('post.class/s');
            $data['mobile'] = I('post.mobile/s');
            $data['email'] = I('post.email/s');
            $data['firstwant'] = I('post.firstWant/s');
            $data['secondwant'] = I('post.secondWant/s');
            $data['intro'] = I('post.intro/s');
            $data['reason'] = I('post.reason/s');
            // 简单数据验证 各项非空 手机格式 邮箱格式
            if ($data['name'] == '' || $data['sex'] == '' || $data['native_place'] == ''
                || $data['academy'] == '' || $data['class'] == '' || $data['mobile'] == ''
                || $data['email'] == '' || $data['firstwant'] == '0' || $data['secondwant'] == '0'
                || $data['intro'] == '' || $data['reason'] == ''
                || !preg_match('/^1\\d{10}$/', $data['mobile'])
                || !preg_match('/^(\\w-*\\.*)+@(\\w-?)+(\\.\\w{2,})+$/', $data['email'])
            ) {
                // 数据验证没过
                $returnData['status'] = '201';
                $returnData['data'] = '数据格式不正确，请重新填写！';
            } else {
                // 获取IP
                if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } elseif ($_SERVER["HTTP_CLIENT_IP"]) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                } elseif ($_SERVER["REMOTE_ADDR"]) {
                    $ip = $_SERVER["REMOTE_ADDR"];
                } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
                    $ip = getenv("HTTP_X_FORWARDED_FOR");
                } elseif (getenv("HTTP_CLIENT_IP")) {
                    $ip = getenv("HTTP_CLIENT_IP");
                } elseif (getenv("REMOTE_ADDR")) {
                    $ip = getenv("REMOTE_ADDR");
                } else {
                    $ip = '';
                }
                if ($ip != '') {
                    // 获取到IP
                    $Apply2 = M("apply2");
                    if ($Apply2->where("ip = '%s'", array($ip))->count() < 10) {
                        // 该IP的数据没有超过10条
                        if ($Apply2->where("name = '%s' and mobile = '%s'", array(
                                $data['name'],
                                $data['mobile'],
                            ))->count() <= 0
                        ) {
                            // 该姓名和手机没有提交过

                            // 部门代码映射为名称
                            $data['firstwant'] = $department[$data['firstwant']];
                            $data['secondwant'] = $department[$data['secondwant']];
                            // 性别映射为汉字
                            $data['sex'] = ($data['sex'] == 0) ? '男' : '女';
                            $data['ip'] = $ip;

                            $data['timestamp'] = time();
                            if ($Apply2->data($data)->add()) {
                                // 新增数据成功
                                $returnData['status'] = '200';
                                $returnData['data'] = '报名申请提交成功！';
                            } else {
                                // 数据写入异常
                                $returnData['status'] = '202';
                                $returnData['data'] = '报名申请记录失败，请重试！';
                            }
                        } else {
                            // 已提交过
                            $returnData['status'] = '205';
                            $returnData['data'] = '您已提交过报名申请啦，小瞳随后会通知你的哟！';
                        }
                    } else {
                        // 某IP提交过多
                        $returnData['status'] = '203';
                        $returnData['data'] = '根据ip判断您已提交过很多报名表啦~';
                    }
                } else {
                    // 未获取到IP
                    $returnData['status'] = '204';
                    $returnData['data'] = '检测到您的ip非法，请重试或换一部设备提交，谢谢！';
                }
            }
            // 返回json数据
            // var_dump($returnData);
            $this->ajaxReturn($returnData);
        } else {
            // 未提交数据
            $this->error("同学别闹。。。");
        }
    }

    /**
     * 输出静态部门介绍
     */
    public function department()
    {
        $this->display();
    }

    /**
     * 删除报名信息
     * 获取报名信息id
     */
    public function delete()
    {
        // 验证登录
        if (session("?name")) {
            // 已登录
            // 获取id
            $id = I('id');
            $Apply2 = M("apply2");
            if ($Apply2->where("id = '%d'", array($id))->delete() === false) {
                $this->error("删除信息失败！");
            } else {
                $this->success("删除信息成功！");
            }
        } else {
            // 跳转至登录界面
            $this->redirect(U("backLogin"));
        }
    }

    /**
     * 输出报名表单
     */
    public function form()
    {
        $this->display();
    }

    /**
     * 后台登录界面
     */
    public function backLogin()
    {
        if (IS_POST) {
            $username = I("post.username");
            $password = I("post.password");
            if ($username == C("USERNAME") && $password == C("PASSWORD")) {
                session("name", md5("MANAGER"));
                $this->redirect(U("back2"));
            } else {
                $this->error("用户名或密码错误！", U("backLogin"));
            }
        } else {
            $this->display();
        }
    }

    /**
     * 旧的报名信息
     * 后台管理界面 若未登录跳转至登录界面
     */
    public function back()
    {
        if (session("?name")) {
            $Apply = M("apply");
            $total = $Apply->count();
            $NUM = 20;
            $maxPage = ceil($total / $NUM);
            $page = I("get.page");
            if ($page > $maxPage) {
                $page = $maxPage;
            }
            if ($page <= 0) {
                $page = 1;
            }
            $results = $Apply->limit(($page - 1) * $NUM, $NUM)->order("timestamp desc")->select();
            $this->assign("results", $results);
            $this->assign("page", $page);
            $this->assign("max", $maxPage);
            $this->display();
        } else {
            $this->redirect(U("backLogin"));
        }
    }

    /**
     * 报名成功
     */
    public function ok()
    {
        $this->display();
    }

    /**
     * 新的报名信息
     * 后台管理界面 若未登录跳转至登录界面
     */
    public function back2()
    {
        if (session("?name")) {
            // 展示报名汇总表格
            $Apply2 = M("apply2");
            $total = $Apply2->count();
            // 每页显示条数
            $NUM = 20;
            // 最大页数
            $maxPage = ceil($total / $NUM);
            // 当前页数
            $page = I("get.page");// 获取GET值
            if ($page > $maxPage) {
                $page = $maxPage;
            }// 超出最大值
            if ($page <= 0) {
                $page = 1;
            }// 低于最小值
            $results = $Apply2->limit(($page - 1) * $NUM, $NUM)->order("timestamp desc")->select();
            $this->assign("results", $results);
            $this->assign("page", $page);
            $this->assign("max", $maxPage);
            $this->display();
        } else {
            $this->redirect(U("backLogin"));
        }
    }
    /**
     * 旧的报名信息导出excel
     */
    public function excel()
    {
        $Apply = M("apply");
        $datas = $Apply->order("timestamp desc")->select();
        Vendor("PHPExcel.PHPExcel");
        $objPhpExcel = new \PHPExcel();
        $rowVal = array(
            0 => '姓名',
            1 => '性别',
            2 => '民族',
            3 => '专业班级',
            4 => '出生日期',
            5 => '籍贯',
            6 => '书院',
            7 => '手机',
            8 => '宿舍',
            9 => '邮箱',
            10 => 'QQ',
            11 => '第一志愿',
            12 => '第二志愿',
            13 => '是否服从调剂',
            14 => '竞聘原因',
            15 => '个人简历',
        );
        foreach ($rowVal as $k => $r) {
            $objPhpExcel->getActiveSheet()
                ->getStyleByColumnAndRow($k, 1)
                ->getFont()
                ->setBold(true);//字体加粗

            $objPhpExcel->getActiveSheet()
                ->getStyleByColumnAndRow($k, 1)
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//文字居中

            $objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow($k, 1, $r);
        }
        $objActSheet = $objPhpExcel->getActiveSheet();
        //设置当前活动的sheet的名称
        $title = "招新报名统计表";
        $objActSheet->setTitle($title);
        //设置单元格内容
        foreach ($datas as $k => $v) {
            $num = $k + 2;
            $objPhpExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A' . $num, $v['name'])
                ->setCellValue('B' . $num, $v['sex'])
                ->setCellValue('C' . $num, $v['nation'])
                ->setCellValue('D' . $num, $v['profession'])
                ->setCellValue('E' . $num, $v['year'] . "." . $v['month'] . "." . $v['day'])
                ->setCellValue('F' . $num, $v['native_place'])
                ->setCellValue('G' . $num, $v['academy'])
                ->setCellValue('H' . $num, $v['mobile'])
                ->setCellValue('I' . $num, $v['dormitory'])
                ->setCellValue('J' . $num, $v['e_mail'])
                ->setCellValue('K' . $num, $v['qq'])
                ->setCellValue('L' . $num, $v['first_department'])
                ->setCellValue('M' . $num, $v['second_department'])
                ->setCellValue('N' . $num, $v['obey'])
                ->setCellValue('O' . $num, $v['reason'])
                ->setCellValue('P' . $num, $v['introduction']);
        }
        $name = date('Y-m-d');//设置文件名
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Transfer-Encoding:utf-8");
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $title . '_' . urlencode($name) . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPhpExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    /**
     * 新的报名信息导出excel
     */
    public function excel2()
    {
        $Apply2 = M("apply2");
        $datas = $Apply2->order("timestamp desc")->select();
        Vendor("PHPExcel.PHPExcel");
        $objPhpExcel = new \PHPExcel();
        $rowVal = array(
            0 => '姓名',
            1 => '性别',
            2 => '专业班级',
            3 => '籍贯',
            4 => '书院',
            5 => '手机',
            6 => '邮箱',
            7 => '第一志愿',
            8 => '第二志愿',
            9 => '个人简历',
            10 => '为什么加入e瞳网',
            11 => '简历投递时间',
            12 => 'IP',
        );
        foreach ($rowVal as $k => $r) {
            $objPhpExcel->getActiveSheet()
                ->getStyleByColumnAndRow($k, 1)
                ->getFont()
                ->setBold(true);//字体加粗

            $objPhpExcel->getActiveSheet()
                ->getStyleByColumnAndRow($k, 1)
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//文字居中

            $objPhpExcel->getActiveSheet()->setCellValueByColumnAndRow($k, 1, $r);
        }
        $objActSheet = $objPhpExcel->getActiveSheet();
        //设置当前活动的sheet的名称
        $title = "招新报名统计表";
        $objActSheet->setTitle($title);
        //设置单元格内容
        foreach ($datas as $k => $v) {
            $num = $k + 2;
            $objPhpExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A' . $num, $v['name'])
                ->setCellValue('B' . $num, $v['sex'])
                ->setCellValue('C' . $num, $v['class'])
                ->setCellValue('D' . $num, $v['native_place'])
                ->setCellValue('E' . $num, $v['academy'])
                ->setCellValue('F' . $num, $v['mobile'])
                ->setCellValue('G' . $num, $v['email'])
                ->setCellValue('H' . $num, $v['firstwant'])
                ->setCellValue('I' . $num, $v['secondwant'])
                ->setCellValue('J' . $num, $v['intro'])
                ->setCellValue('K' . $num, $v['reason'])
                ->setCellValue('L' . $num, $v['create_time'])
                ->setCellValue('M' . $num, $v['ip']);
        }
        $name = date('Y-m-d');//设置文件名
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Transfer-Encoding:utf-8");
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $title . '_' . urlencode($name) . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPhpExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
