<?php

namespace App\Filament\Resources\Tracks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TrackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                FileUpload::make('image')
                    ->disk('public'),                                                                                             
                FileUpload::make('path')
                    ->disk("public")->maxSize(50000),
                Select::make('status')
                    ->required()
                    ->options([
                        'show' => 'Show',
                        'hide' => 'Hide',
                    ])
                    ->default('show')
                    ->native(false),
                TextInput::make('time')
                    ->required(),
                Select::make('playlist_id')
                    ->required()
                    ->relationship(name: 'playlists', titleAttribute: 'name'),
            ]);
    }
}
