<?php
  
  return [
      'slack' => [
          'low_stock_channel_url' => env('SLACK_URL'),
        ],
      'email' => [
          'low_stock_report' => env('LOW_STOCK_REPORT_MAIL', 'azmirsabir1@gmail.com'),
        ]
    ];
