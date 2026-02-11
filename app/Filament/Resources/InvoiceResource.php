<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Card;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Icon Dokumen
    protected static ?string $navigationGroup = 'Transaksi'; // Dikelompokkan biar rapi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    // Pilih Langganan (Otomatis cari nama pelanggan)
                    Select::make('subscription_id')
                        ->relationship('subscription', 'id') // Nanti kita tweak biar muncul nama
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->customer->name} - {$record->package->name}")
                        ->searchable()
                        ->preload()
                        ->required()
                        ->label('Pelanggan & Paket'),

                    TextInput::make('invoice_number')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->label('Nomor Invoice'),

                    TextInput::make('amount')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->label('Jumlah Tagihan'),

                    Select::make('status')
                        ->options([
                            'unpaid' => 'Belum Lunas',
                            'paid' => 'Lunas',
                        ])
                        ->default('unpaid')
                        ->required(),

                    TextInput::make('payment_link')
                        ->url()
                        ->label('Link Pembayaran (Paper.id)')
                        ->columnSpanFull(), // Biar panjang ke samping

                    DateTimePicker::make('paid_at')
                        ->label('Tanggal Bayar'),
                ])->columns(2) // Bagi 2 kolom
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable()
                    ->label('No. Invoice'),

                // Menampilkan Nama Pelanggan via Relasi Subscription
                TextColumn::make('subscription.customer.name')
                    ->searchable()
                    ->label('Pelanggan'),

                TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Tagihan'),

                // Status dengan Warna
                BadgeColumn::make('status')
                    ->colors([
                        'danger' => 'unpaid',
                        'success' => 'paid',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unpaid' => 'Belum Lunas',
                        'paid' => 'Lunas',
                    })
                    ->label('Status'),

                TextColumn::make('created_at')
                    ->date('d M Y')
                    ->label('Tanggal Buat'),
            ])
            ->filters([
                // Filter biar gampang cari yang belum bayar
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'unpaid' => 'Belum Lunas',
                        'paid' => 'Lunas',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // Tombol Pintas: Buka Link Paper.id
                Tables\Actions\Action::make('open_payment')
                    ->label('Buka Link')
                    ->icon('heroicon-o-link')
                    ->url(fn (Invoice $record) => $record->payment_link)
                    ->openUrlInNewTab()
                    ->visible(fn (Invoice $record) => !empty($record->payment_link)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}