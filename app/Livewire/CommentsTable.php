<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
use Filament\Forms\Components as FormComponents;
use App\Models\Comment;

class CommentsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public int $blogId = 0;


    public function render()
    {
        return view('livewire.comments-table');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Comment::query()->where('blog_id', $this->blogId))
            ->columns([
                Tables\Columns\ToggleColumn::make('active'),
                Tables\Columns\TextColumn::make('username'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->model('App\Models\Comment')
                        ->form($this->getFormArray()),
                    Tables\Actions\ReplicateAction::make()
                        ->model('App\Models\Comment'),
                    Tables\Actions\DeleteAction::make()
                        ->model('App\Models\Comment'),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('Add Comment'))
                    ->model('App\Models\Comment')
                    ->form($this->getFormArray())
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['blog_id'] = $this->blogId;
                        return $data;
                    }),
            ]);
    }

    public function getFormArray(): array
    {
        return [
            FormComponents\Toggle::make('active')
                ->onIcon('heroicon-s-lock-open')
                ->offIcon('heroicon-s-lock-closed')
                ->default(1),
            FormComponents\TextInput::make('username')
                ->required()
                ->maxLength(255),
            FormComponents\Textarea::make('comment')
                ->required(),
        ];
    }

}
