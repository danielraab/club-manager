<?php

namespace App\Livewire\Settings;

use App\Facade\NotificationMessage;
use App\Models\Configuration;
use App\Models\ConfigurationKey;
use App\Models\UploadedFile;
use App\NotificationMessage\Item;
use App\NotificationMessage\ItemType;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Appearance extends Component
{
    use WithFileUploads;

    #[Validate(['logoFile' => 'file|mimes:png,jpg,pdf,svg|max:1024'])]
    public ?TemporaryUploadedFile $logoFile = null;

    public ?string $appName;

    public ?int $logoFileId;

    public function mount(): void
    {
        $this->appName = Configuration::getString(ConfigurationKey::APPEARANCE_APP_NAME);
        $this->logoFileId = (int) Configuration::getInt(ConfigurationKey::APPEARANCE_APP_LOGO_ID);
    }

    #[Renderless]
    public function updatedAppName(string $value): void
    {
        Configuration::storeString(
            ConfigurationKey::APPEARANCE_APP_NAME, $value);
    }

    public function deleteFile(): void
    {
        Configuration::storeInt(
            ConfigurationKey::APPEARANCE_APP_LOGO_ID, null);
        UploadedFile::query()->delete($this->logoFileId);
        $this->logoFileId = null;

        Log::info('Logo file deleted', [auth()->user()]);
    }

    public function uploadFile(): void
    {
        $this->validate();

        $user = auth()->user();
        $path = $this->logoFile->store('public/appearance'); // is always public

        $config = Configuration::findByKey(ConfigurationKey::APPEARANCE_APP_LOGO_ID, null);

        $uploadedFile = new UploadedFile();
        $uploadedFile->path = $path;
        $uploadedFile->name = $this->logoFile->getClientOriginalName();
        $uploadedFile->mimeType = $this->logoFile->getMimeType();
        $uploadedFile->forcePublic = true;

        $uploadedFile->storer()->associate($config);
        $uploadedFile->uploader()->associate($user);
        $uploadedFile->save();

        $this->logoFileId = $uploadedFile->id;
        $config->value = $uploadedFile->id;
        $config->save();

        Log::info('Logo file uploaded', [$user, $uploadedFile]);
        NotificationMessage::addNotificationMessage(
            new Item(__('File uploaded.'), ItemType::SUCCESS));
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.settings.appearance');
    }
}
