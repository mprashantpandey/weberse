<?php

namespace App\Services\Auth;

use App\Mail\StoreAccountClaimMail;
use App\Models\Auth\AccountClaimToken;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountClaimService
{
    public function issueForUser(User $user): string
    {
        $plain = Str::random(48);
        $hash = hash('sha256', $plain);

        AccountClaimToken::query()->create([
            'user_id' => $user->id,
            'token_hash' => $hash,
            'expires_at' => now()->addDay(),
        ]);

        return $plain;
    }

    public function sendClaimEmail(User $user, string $plainToken): void
    {
        $url = route('account.claim.show', ['token' => $plainToken]);

        Mail::to($user->email)->send(new StoreAccountClaimMail($user, $url));
    }

    public function resolveValidToken(string $plainToken): ?AccountClaimToken
    {
        $hash = hash('sha256', $plainToken);

        /** @var AccountClaimToken|null $record */
        $record = AccountClaimToken::query()
            ->where('token_hash', $hash)
            ->whereNull('used_at')
            ->first();

        if (! $record) {
            return null;
        }

        if ($record->expires_at && $record->expires_at->isPast()) {
            return null;
        }

        return $record;
    }
}

