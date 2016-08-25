<?php
require_once dirname(__FILE__) . '/../../libs/PHPExcel.php';
require_once dirname(__FILE__) . '/../../libs/PHPExcel/IOFactory.php';
require_once dirname(__FILE__) . '/../DAL/StudentDAL.inc.php';
require_once dirname(__FILE__) . '/../DAL/ClassDAL.inc.php';
require_once dirname(__FILE__) . '/../function/Auth.inc.php';

/**
 * yibao short summary.
 *
 * yibao description.
 *
 * @version 1.0
 * @author Ain
 */
class Yibao
{

    public static $field = array(
        'school'   =>   '学院',
        'major'    =>   '专业',
        'classid'  =>   '班级',
        'stuid'    =>   '学号',
        'sex'      =>   '性别',
        'name'     =>   '姓名',
        'identification' => '身份证号',
        'birthday' =>   '出生年月',
        'insured'  =>   '参保',
        'levelname'=>   '奖学金名称',
        'money'    =>   '奖学金金额',
        'note'     =>   '备注'
    );
    /*
     * 导出excel
     */
    public static function exportExcel($condition = array('school' => NULL,'major'=>NULL,'classid' => NULL, 'insured' => NULL))
    {
        $studentDal = new StudentDAL();
        $studentList = $studentDal->GetStudentList($condition);
        $filename = dirname(__FILE__) . '/../../public/exceltemplate.xls';
        if ($studentList && file_exists($filename)) {
            $fileType = PHPExcel_IOFactory::identify($filename);
            $objReader = PHPExcel_IOFactory::createReader($fileType);
            $objPHPExcel = $objReader->load($filename);
            $objPHPExcel->getProperties()->setCreator('wyuxsc')->setLastModifiedBy('wyuxsc');
            $objSheet = $objPHPExcel->getActiveSheet();
            $num = 3;
            foreach ($studentList as $item) {
                if($item['insured']=='1'){
                    $item['insured']='参保';
                }
                else if($item['insured']=='0'){
                    $item['insured']='不参保';
                }
                else{
                    $item['insured']='';
                }
                $objSheet->setCellValue('A' . $num, $num - 2)->setCellValue('B' . $num, $item['school'])->setCellValue('C' . $num, $item['major'])->setCellValue('D' . $num, $item['classid'])->setCellValue('E' . $num, $item['stuid'])->setCellValue('F' . $num, $item['name'])->setCellValue('G' . $num, $item['identification'])->setCellValue('H' . $num, $item['sex'])->setCellValue('I' . $num, $item['birthday'])->setCellValue('J' . $num, $item['insured'])->setCellValue('K' . $num, $item['note']);
                $num++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="test.xls"');
            $objWriter->save('php://output');
            exit;
        } else {
            return false;
        }
    }

    /*
     * 字段导出
     */
    public static function exportExcelByField($condition = array('school' => NULL,'major'=>NULL,'class' => NULL, 'insured' => NULL),$fields=NULL)
    {
        $studentDal = new StudentDAL();
        $studentList = $studentDal->GetStudentList($condition);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator('wyuxsc')->setLastModifiedBy('wyuxsc');
        $objPHPExcel->createSheet();
        $objSheet = $objPHPExcel->getActiveSheet();
        $objSheet->setCellValue('A1','序号');
        $asc = 66;
        foreach($fields as $field){
            $objSheet->setCellValue(chr($asc).'1',self::$field[$field]);
            $asc++;
        }
        $num = 2;
        foreach ($studentList as $item) {
            if($item['insured']=='1'){
                    $item['insured']='是';
            }
                else if(empty($item['insured'])){
                    $item['insured']='否';
                }
                if(!empty($item['scholarship'])){
                    $item['scholarship'] = unserialize($item['scholarship']);
                    $scholarship = '';
                    foreach($item['scholarship'] as $item){
                        $scholarship .= $item['scholarship_name'].':'+$item['money'];
                        if($item != end($item['scholarship'])){
                            $scholarship .= '\n';
                        }
                    }
                }
                $asc = 66;
                $objSheet->setCellValue('A'.$num,$num-1);
                foreach($fields as $field){
                    $objSheet->setCellValue(chr($asc).$num,$item[$field]);
                    $asc++;
                }
                $num++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.uniqid().'.xls"');
            $objWriter->save('php://output');
            exit;
    }
    /*
     * 导入
     */
    public static function importDb($data)
    {
        if (Auth::AdminCheck())
            $schoolid = false;
        else if (Auth::TeacherCheck())
            $schoolid = $_SESSION['teacher_schoolid'];
        else
            exit;
        $studentdal = new StudentDAL();
        $classdal = new ClassDAL();
        $result['existedcount'] = 0;
        $result['succeedcount'] = 0;
        $result['failedcount'] = 0;
        foreach ($data as $row) {
            if ($schoolid)
                if (!$classdal->GetClassOne(array('classid' => $row['classid'], 'schoolid' => $schoolid)))
                    continue;
            if ($studentdal->GetStudentOne(array('stuid' => $row['stuid'])))
                $result['existedcount']++;
            else {
                if ($studentdal->CreateStudent($row))
                    $result['succeedcount']++;
                else
                    $result['failedcount']++;
            }
        }
        return $result;
    }

    public static function preimport($filename)
    {
        $studentdal = new StudentDAL();
        $data['succeeddata'] = array();
        $data['faileddata'] = array();
        $row = array();
        $fileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($filename);        
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();

        $sheetdata = $objWorksheet->toArray();

        for ($i = 2; $i < $highestRow; $i++) {
            $row['stuid'] = $sheetdata[$i][4];
            $row['name'] = $sheetdata[$i][5];
            $row['school'] = $sheetdata[$i][1];
            $row['major'] = $sheetdata[$i][2];
            $row['classid'] = $sheetdata[$i][3];
            $row['identification'] = $sheetdata[$i][6];
            $row['sex'] = $sheetdata[$i][7];
            $row['birthday'] = date('Y-m-d', strtotime($sheetdata[$i][8]));
            $row['insured']=$sheetdata[$i][9];
            $row['note'] = $sheetdata[$i][10];
            if (!$studentdal->GetStudentOne(array('stuid' => $row['stuid'])))
                $data['succeeddata'][] = $row;
            else
                $data['faileddata'][] = $row;
        }
        return $data;
    }
}