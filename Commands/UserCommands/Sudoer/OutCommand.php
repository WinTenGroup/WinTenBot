<?php
/**
 * Created by PhpStorm.
 * User: Azhe
 * Date: 21/09/2018
 * Time: 22.05
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use WinTenDev\Model\Group;
use WinTenDev\Utils\Time;

class OutCommand extends UserCommand
{
	protected $name = 'out';
	protected $description = 'Force out bot, (for sudoer only, even not admin)';
	protected $usage = '/out';
	protected $version = '1.0.0';
	
	/**
	 * Execute command
	 *
	 * @return void
	 * @throws TelegramException
	 */
	public function execute()
	{
		$message = $this->getMessage();
		$chat_id = $message->getChat()->getId();
		$mssg_id = $message->getMessageId();
		$from_id = $message->getFrom()->getId();
		$pecah = explode(' ', $message->getText());
		
		$time = $message->getDate();
		$time = Time::jeda($time);
		
		$isSudoer = Group::isSudoer($from_id);
		
		if ($isSudoer) {
			if (isBeta && $pecah[1] == 'beta') {
				Request::deleteMessage([
					'chat_id'    => $chat_id,
					'message_id' => $mssg_id
				]);
				Request::sendMessage([
					'chat_id'    => $chat_id,
					'text'       => "I'm leave" . $time,
					'parse_mode' => 'HTML'
				]);
				
				Request::leaveChat(['chat_id' => $chat_id]);
			}
		}
	}
}
