<?php


namespace App\Enums;

enum ActivationStatus: string
{
    case Activated = 'Activated';
    case NotActivated = 'Not Activated';
    case OrderNotConfirmed = 'Order not confirmed';
    case Refund = 'Refund';
    case OrderOnHold = 'Order on hold';
    case PremiumIDIssue = 'Premium ID Issue';
    case OrderCancelled = 'Order cancelled';
    case NotAvailable = 'N/A';
}

