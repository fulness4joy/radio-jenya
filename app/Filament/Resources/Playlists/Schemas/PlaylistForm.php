<?php

namespace App\Filament\Resources\Playlists\Schemas;

use DateTime;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class PlaylistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                FileUpload::make('image')
                    ->image(),
                Select::make('channel_id')
                    ->required()
                    ->relationship(name: 'channel', titleAttribute: 'name'),
                DateTimePicker::make('time_start')
                    ->required(),
                // Select::make('track_id')
                //     ->required()
                //     ->relationship(name: 'tracks', titleAttribute: 'name'),
            ]);
    }
}
