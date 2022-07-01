<?php

class Avatar
{
    const WIDTH = 256;
    const HEIGHT = 256;
    protected $sName, $obImage, $sMoustache;

    public function __construct(string $sName = "", bool $sMoustache = false)
    {
        // Создание пустого изображения.
        $this->obImage = imagecreatetruecolor(self::WIDTH, self::HEIGHT);

        $this->sName = $sName;
        $this->sMoustache = $sMoustache;
        $this->generateAvatar();
    }

    public function generateAvatar()
    {
        // Генерация числа из имени
        $sName = $this->getName();
        // Выбор цвета фона
        $this->createBackGround($sName[0]);
        // Отрисовка бровей
        $this->createEyebrows($sName[1]);
        // Отрисовка глаз
        $this->createEyes();
        // Отрисовка усов
        if ($this->sMoustache === true) {
            $this->createMoustache($sName[3]);
        }
        // Отрисовка рта
        $this->createMouth($sName[2]);

        // Сохранение изображения.
        $sNameFile = "avatar-" . $this->sName . ".png";
        imagepng($this->obImage, $sNameFile);
        imagedestroy($this->obImage);
        echo $_SERVER["DOCUMENT_ROOT"] . "/" . $sNameFile . "<br>";
    }

    // Генерация числа из имени
    private function getName(): string
    {
        if ($this->sName === "") return "";
        return substr(hexdec(md5($this->sName)), 3, 10);
    }

    // Выбор цвета фона
    private function createBackGround($sName): void
    {
        $iColor = $this->getColor($sName);
        imagefill($this->obImage, 0, 0, $iColor);
    }

    // Отрисовка бровей
    private function createEyebrows($sName): void
    {
        $iColor = $this->getColor($sName);
        imagefilledrectangle($this->obImage, 48, 20, 100, 30, $iColor);
        imagefilledrectangle($this->obImage, self::WIDTH - 48, 20, self::WIDTH - 100, 30, $iColor);
    }

    // Отрисовка глаз
    private function createEyes(): void
    {
        $iColorEyes = imagecolorallocate($this->obImage, 255, 255, 255);
        $iColorPupils = imagecolorallocate($this->obImage, 0, 0, 0);
        $iPositionPupils = rand(60, 90);
        imagefilledellipse($this->obImage, 75, 75, 50, 50, $iColorEyes);
        imagefilledellipse($this->obImage, self::WIDTH - 75, 75, 50, 50, $iColorEyes);
        imagefilledellipse($this->obImage, 75, $iPositionPupils, 20, 20, $iColorPupils);
        imagefilledellipse($this->obImage, self::WIDTH - 75, $iPositionPupils, 20, 20, $iColorPupils);
    }

    // Отрисовка усов
    private function createMoustache($sName): void
    {
        $arCoordinates = array(
            123, 153, 133, 153, 133, 163, 143, 163, 143, 173, 193, 173, 193, 163, 203, 163, 203, 153, 213, 153, 213, 143, 193, 143, 193, 153, 173, 153, 173, 143, 153, 143, 153, 133, 133, 133, 133, 143, 123, 143, 123, 133, 103, 133, 103, 143, 83, 143, 83, 153, 63, 153, 63, 143, 43, 143, 43, 153, 53, 153, 53, 163, 63, 163, 63, 173, 113, 173, 113, 163, 123, 163
        );
        $iColor = $this->getColor($sName);
        imagefilledpolygon($this->obImage, $arCoordinates, 36, $iColor);
    }

    // Отрисовка рта
    private function createMouth($sName): void
    {
        $iColor = $this->getColor($sName);
        imagefilledarc($this->obImage, self::WIDTH / 2, 190, 100, 40, 0, 180, $iColor, IMG_ARC_PIE);
    }

    private function getColor($sName): int
    {
        $arColors = array(
            "1" => array(128, 255, 0),
            "2" => array(178, 255, 102),
            "3" => array(204, 204, 0),
            "4" => array(255, 178, 102),
            "5" => array(255, 102, 102),
            "6" => array(102, 255, 178),
            "7" => array(0, 0, 51),
            "8" => array(102, 178, 255),
            "9" => array(153, 153, 255),
            "10" => array(204, 153, 255),
        );

        if ($sName === "") {
            $arColors = $arColors[rand(1, 10)];
        } else {
            $arColors = $arColors[$sName];
        }

        return imagecolorallocate($this->obImage, $arColors[0], $arColors[1], $arColors[2]);
    }


}