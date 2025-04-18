# Comma Code Company Present => Auto Convert Text To Audio

A Laravel package that automatically converts multilingual text to audio and attaches it to your models.

## Requirements

### PHP
This package requires PHP version **8.1** or higher, and is compatible with PHP versions **8.1, 8.2, and 8.3**.

### Laravel
This package is compatible with the following versions of Laravel:

- Laravel 10.x
- Laravel 11.x
- Laravel 12.x

- SSL Certificate

This Laravel package allows you to automatically convert multilingual content into audio files using Google Cloud Text-to-Speech.

## Installation

```bash
composer require commacodes/auto-convert-text-to-audio
```
## Then, publish the configuration file:

```bash
php artisan vendor:publish --tag=config
```
## Usage

### Move Your Google Service Account Json File to This Path and Rename It To "google-tts.json"
```bash
storage/app/google/google-tts.json
```

## Add This Trait To Your Model "HasMultilangTTS"
```bash
<?php

namespace App\Models;

use commacodes\AutoConvertTextToAudio\Traits\HasMultilangTTS;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Post extends Model
{
    use HasFactory, HasMultilangTTS;

    protected $guarded = [];

}
```


## Add the required columns to your model's database table
### You need to add the necessary columns (audio_en, audio_fr, audio_ar) to your table:
```php
Schema::table('your_model_table', function (Blueprint $table) {
    $table->string('audio_en')->nullable();
    $table->string('audio_fr')->nullable();
    $table->string('audio_ar')->nullable();
});
```
## Add the following code to your Controller
### Add the HasMultilangTTS trait to your  Controller , call the generateTTS method to convert your multilingual text content into audio.

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use commacodes\AutoConvertTextToAudio\Traits\HasMultilangTTS;

class PostController extends Controller
{
    use HasMultilangTTS;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->name =   $request->name;
        $post->notes    =   ['en' => $request->notes, 'ar' => $request->notes_ar, 'fr' => $request->notes_fr];
        $post->save();
        $post->generateTTS([
            'ar' => $request->notes_ar,
            'en' => $request->notes,
            'fr' =>  $request->notes_fr,
        ]);
        return redirect()->route('post_index');
    }


}
```
### To View MP3 Files

```php
{{asset('upload/tts/'.$your_var->audio_en)}}
{{asset('upload/tts/'.$your_var->audio_ar)}}
{{asset('upload/tts/'.$your_var->audio_fr)}}
```

## Made With Love By Comma Code Comapny <a href="https://commacodes.com/" target="_blank">Visit Us</a>
