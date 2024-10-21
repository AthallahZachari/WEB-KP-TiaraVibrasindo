<?php
class detailClass
{
    public $ID;
    public $nama;
    public $materi;
    public $pengajar;
    public $ruangan;
    public $durasi;

    public function __construct($detail) {
        $this->ID = $detail['id_class'];
        $this->nama = $detail['nama_kelas'];
        $this->materi = $detail['nama_materi'];
        $this->pengajar = $detail['admin_name'];
        $this->ruangan = $detail['ruangan'];
        $this->durasi = $detail['durasi'];
    }
}
