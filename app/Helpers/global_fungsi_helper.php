<?php
function kirim_email($attachment, $to, $title, $message)
{
    $email = \Config\Services::email();
    $email_pengirim = EMAIL_ALAMAT;
    $email_nama = EMAIL_NAMA;

    $config['protocol'] = 'smtp';
    $config['SMTPHost'] = 'smtp.gmail.com';
    $config['SMTPUser'] = $email_pengirim;
    $config['SMTPPass'] = EMAIL_PASSWORD;
    $config['SMTPPort'] = 465;
    $config['SMTPCrypto'] = 'ssl';
    $config['mailType'] = 'html';

    $email->initialize($config);
    $email->setFrom($email_pengirim, $email_nama);
    $email->setTo($to);

    if ($attachment) {
        $email->attach($attachment);
    }

    $email->setSubject($title);
    $email->setMessage($message);

    if (!$email->send()) {
        $data = $email->printDebugger(['headers']);
        print_r($data);
        return false;
    } else {
        return true;
    }

    /**
     * Summary of nomor
     * @param mixed $currentPage
     * @param mixed $jumlahBaris
     * @return float|int
     */

}

function kirim_email_user($attachment, $to, $title, $message)
{
    $email = \Config\Services::email();
    $email_pengirim = EMAIL_ALAMAT_USER;
    $email_nama = EMAIL_NAMA_USER;

    $config['protocol'] = 'smtp';
    $config['SMTPHost'] = 'smtp.gmail.com';
    $config['SMTPUser'] = $email_pengirim;
    $config['SMTPPass'] = EMAIL_PASSWORD_USER;
    $config['SMTPPort'] = 465;
    $config['SMTPCrypto'] = 'ssl';
    $config['mailType'] = 'html';

    $email->initialize($config);
    $email->setFrom($email_pengirim, $email_nama);
    $email->setTo($to);

    if ($attachment) {
        $email->attach($attachment);
    }

    $email->setSubject($title);
    $email->setMessage($message);

    if (!$email->send()) {
        $data = $email->printDebugger(['headers']);
        print_r($data);
        return false;
    } else {
        return true;
    }

    /**
     * Summary of nomor
     * @param mixed $currentPage
     * @param mixed $jumlahBaris
     * @return float|int
     */

}
function nomor($currentPage, $jumlahBaris)
{
    if (is_null($currentPage)) {
        $nomor = 1;
    } else {
        $nomor = 1 + ($jumlahBaris * ($currentPage - 1));
    }
    return $nomor;
}

function tanggal_indo($parameter)
{
    // 	2023-09-21 11:25:35
    // tahun-bulan-hari waktu
    $split1 = explode(" ", $parameter);
    $parameter1 = $split1[0]; // 2022-03-11

    $bulan = [
        '1' => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $hari = [
        '1' => 'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    ];
    $num = date('N', strtotime($parameter1)); //jumat => 5
    $split2 = explode('-', $parameter1); // 2022, 03, 11
    return $hari[$num] . ", " . $split2[2] . " " . $bulan[(int) $split2[1]] . " " . $split2[0];
}

function purify($dirty_html)
{
    $config = HTMLPurifier_Config::createDefault();
    $config->set('URI.AllowedSchemes', array('data' => true));
    $purifier = new HTMLPurifier($config);
    $clean_html = $purifier->purify($dirty_html);
    return $clean_html;
}

function notif_swal($icon, $title)
{
    session()->setFlashdata('swal_icon', $icon);
    session()->setFlashdata('swal_title', $title);
}

/** Buat halaman index */
function notif_swal_dua($icon, $text)
{
    session()->setFlashdata('swal_icon2', $icon);
    session()->setFlashdata('swal_text2', $text);
}

/** Buat berhasil absen */
function notif_swal_tiga($icon, $text, $title)
{
    session()->setFlashdata('swal_icon3', $icon);
    session()->setFlashdata('swal_text3', $text);
    session()->setFlashdata('swal_title3', $title);
}