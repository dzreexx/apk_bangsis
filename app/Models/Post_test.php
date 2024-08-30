<?php

namespace App\Models;

class Post
{
    private static $documents = [
        [
            "id" => "1",
            "no" => "120000827",
            "tanggal" => "7-09-2031",
            "judul" => "dunia Kerja",
            "permohonan" => "27",
            "asal" => "mabes ad",
            "tujuan" => "mengelola",
            "file" => "welcome"
        ],
        [
            "id" => "2",
            "no" => "12023420827",
            "tanggal" => "2-09-2001",
            "judul" => "hello Kerja",
            "permohonan" => "9",
            "asal" => "mabes al",
            "tujuan" => "mulawarman",
            "file" => "welcome"
        ],
        [
            "id" => "3",
            "no" => "1639182631",
            "tanggal" => "27-09-2001",
            "judul" => "ayok Kerja",
            "permohonan" => "1",
            "asal" => "mabes au",
            "tujuan" => "menawarkan",
            "file" => "welcome"
        ],
        [
            "id" => "4",
            "no" => "12230827",
            "tanggal" => "27-09-2012",
            "judul" => "dunia jawa",
            "permohonan" => "0",
            "asal" => "mabes al",
            "tujuan" => "menjawab",
            "file" => "welcome"
        ],
        [
            "id" => "5",
            "no" => "120000827",
            "tanggal" => "7-09-2031",
            "judul" => "dunia Kerja",
            "permohonan" => "27",
            "asal" => "mabes ad",
            "tujuan" => "mengelola",
            "file" => "welcome"
        ],
        [
            "id" => "6",
            "no" => "12023420827",
            "tanggal" => "2-09-2001",
            "judul" => "hello Kerja",
            "permohonan" => "9",
            "asal" => "mabes al",
            "tujuan" => "mulawarman",
            "file" => "welcome"
        ],
        [
            "id" => "7",
            "no" => "1639182631",
            "tanggal" => "27-09-2001",
            "judul" => "ayok Kerja",
            "permohonan" => "1",
            "asal" => "mabes au",
            "tujuan" => "menawarkan",
            "file" => "welcome"
        ],
        [
            "id" => "8",
            "no" => "12230827",
            "tanggal" => "27-09-2012",
            "judul" => "dunia jawa",
            "permohonan" => "0",
            "asal" => "mabes al",
            "tujuan" => "menjawab",
            "file" => "welcome"
        ],
        [
            "id" => "9",
            "no" => "120000827",
            "tanggal" => "7-09-2031",
            "judul" => "dunia Kerja",
            "permohonan" => "27",
            "asal" => "mabes ad",
            "tujuan" => "mengelola",
            "file" => "welcome"
        ],
        [
            "id" => "10",
            "no" => "12023420827",
            "tanggal" => "2-09-2001",
            "judul" => "hello Kerja",
            "permohonan" => "9",
            "asal" => "mabes al",
            "tujuan" => "mulawarman",
            "file" => "welcome"
        ],
        [
            "id" => "11",
            "no" => "1639182631",
            "tanggal" => "27-09-2001",
            "judul" => "ayok Kerja",
            "permohonan" => "1",
            "asal" => "mabes au",
            "tujuan" => "menawarkan",
            "file" => "welcome"
        ],
        [
            "id" => "12",
            "no" => "12230827",
            "tanggal" => "27-09-2012",
            "judul" => "dunia jawa",
            "permohonan" => "0",
            "asal" => "mabes al",
            "tujuan" => "menjawab",
            "file" => "welcome"
        ]
        ];

        public static function all()
        {
            return self::$documents;
        }
}
