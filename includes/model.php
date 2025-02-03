<?php
class detailClass
{
    public $ID;
    public $nama;
    public $materi;
    public $pengajar;
    public $ruangan;
    public $durasi;
    public $mulai;

    public function __construct($detail) {
        $this->ID = $detail['id_class'];
        $this->nama = $detail['nama_kelas'];
        $this->materi = $detail['nama_materi'];
        $this->pengajar = $detail['admin_name'];
        $this->ruangan = $detail['ruangan'];
        $this->durasi = $detail['durasi'];
        $this->mulai = $detail['jam'];
    }
}

class detailAttendance{
    public $IDkelas;
    public $studentID;
    public $classID;
    public $status;
    public $time;

    public function __construct($detail){
        $this->IDkelas = $detail['attendance_id'];
        $this->studentID = $detail['student_id'];
        $this->classID = $detail['class_id'];
        $this->status = $detail['status'];
        
    }
}
?>
