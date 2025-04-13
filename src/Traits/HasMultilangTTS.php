<?php

namespace commacodes\AutoConvertTextToAudio\Traits;

use commacodes\AutoConvertTextToAudio\Services\TextToSpeechService;

trait HasMultilangTTS
{
    public function generateTTS(array $translations)
    {
        $service = new TextToSpeechService();
        $service->convertAndAttach($this, $translations);
    }
}
