<?php
header('Content-Type: application/json; charset=utf-8');

$volcanoes = [
    [
        "name" => "Gunung Merapi",
        "provinsi" => "D.I. Yogyakarta & Jawa Tengah",
        "lat" => -7.5407,
        "lon" => 110.4457,
        "tinggi" => "2.930 mdpl",
        "status" => "Siaga (Level III)",
        "deskripsi" => "Gunung api teraktif di Indonesia dengan guguran lava dan awan panas berkala."
    ],
    [
        "name" => "Gunung Semeru",
        "provinsi" => "Jawa Timur",
        "lat" => -8.108,
        "lon" => 112.922,
        "tinggi" => "3.676 mdpl",
        "status" => "Siaga (Level III)",
        "deskripsi" => "Puncak tertinggi di Pulau Jawa, erupsi berkala dengan kolom abu vulkanik."
    ],
    [
        "name" => "Gunung Lewotobi Laki-laki",
        "provinsi" => "Nusa Tenggara Timur",
        "lat" => -8.538,
        "lon" => 122.768,
        "tinggi" => "1.584 mdpl",
        "status" => "Awas (Level IV)",
        "deskripsi" => "Peningkatan aktivitas vulkanik tinggi dengan radius bahaya hingga 7 km."
    ],
    [
        "name" => "Gunung Marapi",
        "provinsi" => "Sumatera Barat",
        "lat" => -0.381,
        "lon" => 100.473,
        "tinggi" => "2.891 mdpl",
        "status" => "Siaga (Level III)",
        "deskripsi" => "Aktivitas hembusan abu vulkanik dan gempa letusan masih terekam."
    ],
    [
        "name" => "Gunung Sinabung",
        "provinsi" => "Sumatera Utara",
        "lat" => 3.170,
        "lon" => 98.392,
        "tinggi" => "2.460 mdpl",
        "status" => "Waspada (Level II)",
        "deskripsi" => "Pemantauan kubah lava dan seismik stabil di level waspada."
    ],
    [
        "name" => "Gunung Anak Krakatau",
        "provinsi" => "Lampung / Selat Sunda",
        "lat" => -6.102,
        "lon" => 105.423,
        "tinggi" => "157 mdpl",
        "status" => "Siaga (Level III)",
        "deskripsi" => "Gunung api kepulauan dengan potensi tsunami akibat longsoran lereng bawah laut."
    ],
    [
        "name" => "Gunung Bromo",
        "provinsi" => "Jawa Timur",
        "lat" => -7.942,
        "lon" => 112.953,
        "tinggi" => "2.329 mdpl",
        "status" => "Waspada (Level II)",
        "deskripsi" => "Aktivitas kawah aktif mengeluarkan asap solfatara dengan getaran tremor terus-menerus."
    ],
    [
        "name" => "Gunung Rinjani",
        "provinsi" => "Nusa Tenggara Barat",
        "lat" => -8.411,
        "lon" => 116.457,
        "tinggi" => "3.726 mdpl",
        "status" => "Normal (Level I)",
        "deskripsi" => "Aktivitas vulkanik dalam batas normal dan terpantau kondusif."
    ],
    [
        "name" => "Gunung Ruang",
        "provinsi" => "Sulawesi Utara",
        "lat" => 2.296,
        "lon" => 125.370,
        "tinggi" => "725 mdpl",
        "status" => "Waspada (Level II)",
        "deskripsi" => "Pasca erupsi eksplosif, status saat ini berangsur waspada dengan pengawasan ketat."
    ],
    [
        "name" => "Gunung Kerinci",
        "provinsi" => "Jambi & Sumatera Barat",
        "lat" => -1.697,
        "lon" => 101.264,
        "tinggi" => "3.805 mdpl",
        "status" => "Waspada (Level II)",
        "deskripsi" => "Gunung berapi tertinggi di Indonesia dengan kepulan asap kawah berkala."
    ]
];

echo json_encode($volcanoes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
