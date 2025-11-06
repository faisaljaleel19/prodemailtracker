<?php
namespace App\Enums;

enum ProductCategories:string {
    case K10Streaming = 'K10 Streaming';
    case NeoClassOnly = 'Neo class Only';
    case AakashLiveClass = 'Aakash Live Class';
    case K10StreamingPlusNeoClass = 'K10 streaming + Neo class';

    case K12AakashSDCard = 'K12 Aakash SD Card';

    case Tabletonly = 'Tablet only';

    case K3SDCardPlusTablet = 'K3 SD Card + Tablet';

    case K3SDCardPlusStreamingPlusTablet = 'K3 SD Card + Streaming + Tablet';

    case K10SDCard = 'K10 SD Card';

    case DNDSDcard = 'DND SD card';

    case DNDStreaming = 'DND Streaming';

    case K10StreamingPlusTablet = 'K10 Streaming + Tablet';
}

