<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Console\Exception\ConsoleException;
use Cake\I18n\Time;

/**
 * MoneyTransfer shell command.
 */
class MoneyTransferShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    private function __help()
    {
        $msg = <<<EOT
    Usage: cake money_transfer <From_User_ID> <To_User_ID> <Amount>

    <From User ID> - required, integer
    <To User ID>   - required, integer
    <Amount>       - required, float
EOT;
        return $msg;
    }

    public function help()
    {
        $this->out($this->__help());
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main(int $fromUserId = null, int $toUserId = null, float $amount = null)
    {
        if (empty($fromUserId) || empty($toUserId) || empty($amount)) {
            $this->out($this->__help());
            return;
        }

        $conn = ConnectionManager::get('default');
        // transaction
        try {
            $conn->begin();
            $usersRows = $conn->execute(
                'SELECT * FROM users WHERE id IN (?, ?) FOR UPDATE',
                [$fromUserId, $toUserId]
            )->fetchAll('assoc');
            $this->_isMoneyTransferValid($usersRows, $fromUserId, $toUserId, $amount);
            $conn->execute(
                'UPDATE users SET wallet_amount = wallet_amount - ?, updated_at = ? WHERE id = ?',
                [$amount, Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss'), $fromUserId]
            );
            $conn->execute(
                'UPDATE users SET wallet_amount = wallet_amount + ?, updated_at = ? WHERE id = ?',
                [$amount, Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss'), $toUserId]
            );
            $conn->commit();
            $this->out("Transaction completed. \n");
            $this->out($this->_drawMoneyTransferPath($usersRows, $fromUserId, $amount));
        } catch (ConsoleException $e) {
            $conn->rollback();
            $this->err($e->getMessage());
            return self::CODE_ERROR;
        }
    }

    protected function _isMoneyTransferValid($usersRows, $fromUserId, $toUserId, $transferAmount)
    {
        $result = [
            'is_valid' => true,
            'error_msg' => ''
        ];
        if (sizeof($usersRows) < 2) {
            $result['is_valid'] = false;
            $result['error_msg'] .= "Wrong user IDs\n";
        }
        foreach ($usersRows as $user) {
            if ($user['id'] == $fromUserId && $user['wallet_amount'] < $transferAmount) {
                $result['is_valid'] = false;
                $result['error_msg'] .= "Transfer amount bigger than wallet amount. User ID: $fromUserId\n";
                break;
            }
        }
        if ($fromUserId == $toUserId) {
            $result['is_valid'] = false;
            $result['error_msg'] .= "Don't use same user ID\n";
        }

        if (!$result['is_valid']) {
            throw new ConsoleException($result['error_msg']);
            return false;
        }

        return true;
    }

    protected function _drawMoneyTransferPath($usersRows, $fromUserId, $transferAmount)
    {
        $fromUserName = '';
        $toUserName = '';

        foreach ($usersRows as $user) {
            if ($user['id'] == $fromUserId) {
                $fromUserName = $user['name'];
            } else {
                $toUserName = $user['name'];
            }
        }

        return $transferAmount . " transferred \n" . $fromUserName . ' ------> ' . $toUserName . "\n";
    }
}
