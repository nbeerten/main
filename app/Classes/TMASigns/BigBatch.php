<?php

// namespace App\Classes\TMASigns;

// use ZipStream;

// /**
//  * Logic for BigBatch generation of signs
//  */
// class BigBatch
// {
//     public function get()
//     {
//         $sizes = [2, 4, 6];

//         $options = new Zipstream\Option\Archive;
//         $options->setSendHttpHeaders(true);

//         $mainzip = new ZipStream\ZipStream('tma-bigbatch-text-and-cp-signs.zip', $options);

//         foreach ($sizes as $size) {
//             if ($size == 6) {
//                 for ($x = 1; $x <= 25; $x++) {
//                     $x = str_pad($x, 2, '0', STR_PAD_LEFT);
//                     $TMASigns = new TMASigns('jpg', $size, [], "Checkpoint {$x}", '');

//                     $mainzip->addFile("Advertisement{$size}x1/tma-CP_{$size}x1/tma-CP-{$x}.jpg", $TMASigns->get());
//                 }
//             }

//             $strings = [
//                 'Start',
//                 'Finish',
//                 'Checkpoint',
//                 'GPS',
//                 'GPS back',
//                 'Multilap',
//             ];

//             if ($size !== 6) {
//                 foreach ($strings as $value) {
//                     $TMASigns = new TMASigns('tga', $size, [], $value, '');
//                     $value = str_replace(' ', '', strtolower($value));

//                     $data = $TMASigns->zipStream();

//                     $mainzip->addFileFromStream("Advertisement{$size}x1/tma-text_{$size}x1/tma-text-{$value}.zip", $data);
//                     fclose($data);
//                 }
//             } elseif ($size == 6) {
//                 foreach ($strings as $value) {
//                     $TMASigns = new TMASigns('jpg', $size, [], $value, '');
//                     $value = str_replace(' ', '', strtolower($value));

//                     $mainzip->addFile("Advertisement{$size}x1/tma-text_{$size}x1/tma-text-{$value}.jpg", $TMASigns->get());
//                 }
//             }
//         }

//         return $mainzip->finish();
//     }
// }
