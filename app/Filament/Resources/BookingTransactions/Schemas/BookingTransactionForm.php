<?php

namespace App\Filament\Resources\BookingTransactions\Schemas;

use App\Models\Cosmetic;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

class BookingTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Wizard::make([
                    Step::make('product and price')
                        ->completedIcon('heroicon-m-hand-thumb-up')
                        ->description('add your product items')
                        ->schema([

                            Repeater::make('transactionDetails')
                                ->relationship('transactionDetails')
                                ->schema([
                                    Grid::make(2)
                                        ->schema([

                                            Select::make('cosmetic_id')
                                                ->relationship('cosmetic', 'name')
                                                ->searchable()
                                                ->preload()
                                                ->required()
                                                ->label('Select Product')
                                                ->live()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    $cosmetic = Cosmetic::find($state);
                                                    $set('price', $cosmetic ? $cosmetic->price : 0);
                                                }),

                                            TextInput::make('price')
                                                ->required()
                                                ->numeric()
                                                ->readOnly()
                                                ->label('Price'),

                                            TextInput::make('quantity')
                                                ->integer()
                                                ->default(1)
                                                ->required(),

                                        ])

                                ])
                                ->minItems(1)
                                ->columnSpan('full')
                                ->label('Choose Products'),
                            Grid::make(4)
                                ->schema([
                                    TextInput::make('quantity')
                                        ->integer()
                                        ->label('Total Quantity')
                                        ->readOnly()
                                        ->default(1)
                                        ->required(),

                                    TextInput::make('sub_total_amount')
                                        ->numeric()
                                        ->readOnly()
                                        ->label('Sub Total Amount'),

                                    TextInput::make('total_amount')
                                        ->numeric()
                                        ->readOnly()
                                        ->label('Total Amount'),

                                    TextInput::make('total_tax_amount')
                                        ->numeric()
                                        ->readOnly()
                                        ->label('Total Tax (11%) ')
                                ])

                        ]),

                ])
                    ->columnSpanFull()
                    ->columns(1)
                    ->skippable()

            ]);
    }
}
