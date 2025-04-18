<?php
// config/dompdf.php
return array(
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf
    'orientation'   => 'portrait',
    'defines'       => array(
        /**
         * The paper size. Defines the paper size of the generated PDF.
         * See https://github.com/dompdf/dompdf/blob/master/src/Adapter/CPDF.php
         * for a list of valid options.
         */
        'DOMPDF_PAPER_SIZE' => 'A4',

        /**
         * The default font family
         */
        'DOMPDF_DEFAULT_FONT' => 'dejavu serif',

        /**
         * Image DPI setting
         */
        'DOMPDF_DPI' => 96,

        /**
         * Enable font subsetting
         */
        'DOMPDF_ENABLE_FONT_SUBSETTING' => true,

        /**
         * Enable remote file access
         */
        'DOMPDF_ENABLE_REMOTE' => true,

        /**
         * Default font options for the PDF
         */
        'font_height_ratio' => 1.1,

        /**
         * Use the more-than-experimental HTML5 Lib parser
         */
        'DOMPDF_ENABLE_HTML5PARSER' => false,
    ),
);
