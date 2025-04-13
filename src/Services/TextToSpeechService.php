<?php

namespace commacodes\AutoConvertTextToAudio\Services;

use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Illuminate\Support\Facades\Storage;
use Grpc\ChannelCredentials;

class TextToSpeechService
{
    public function convertAndAttach($model, array $translations)
    {
        $client = new TextToSpeechClient([
            'credentials' => config('tts.credentials_path')
        ]);

        foreach ($translations as $lang => $text) {
            if (!$text) continue;

            $languageCode = config("tts.languages.$lang.languageCode", 'en-US');
            $gender = config("tts.languages.$lang.gender", 'FEMALE');

            $input = new SynthesisInput();
            $input->setText($text);

            $voice = new VoiceSelectionParams();
            $voice->setLanguageCode($languageCode);
            $voice->setSsmlGender(constant("\Google\Cloud\TextToSpeech\V1\SsmlVoiceGender::$gender"));

            $audioConfig = new AudioConfig();
            $audioConfig->setAudioEncoding(AudioEncoding::MP3);

            $response = $client->synthesizeSpeech($input, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();
            if ($audioContent) {
                $filename = $model->id . '_' . $lang . '.mp3';
                $folderPath = public_path('upload/tts');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }
                $tempPath = $folderPath . '/temp_' . $filename;
                file_put_contents($tempPath, $audioContent);
                $path = $folderPath . '/' . $filename;
                rename($tempPath, $path);
                $column = "audio_$lang";
                $model->$column = $filename;
            }
            $model->save();
        }
        $client->close();
    }
}
