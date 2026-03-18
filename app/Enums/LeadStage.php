<?php

namespace App\Enums;

enum LeadStage: string
{
    case Lead = 'lead';
    case Contacted = 'contacted';
    case ProposalSent = 'proposal_sent';
    case ClosedWon = 'closed_won';
    case ClosedLost = 'closed_lost';

    public static function values(): array
    {
        return array_map(static fn (self $stage) => $stage->value, self::cases());
    }
}
