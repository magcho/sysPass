<?php

namespace SP\Services;

use SP\Account\AccountUtil;
use SP\DataModel\AccountData;
use SP\Log\Log;
use SP\Storage\DbWrapper;
use SP\Storage\QueryData;

/**
 * Class AccountService
 *
 * @package Services
 */
class AccountService extends Service
{
    /**
     * @param $id
     */
    public function getAccount($id)
    {

    }

    /**
     * @param $id
     * @return AccountData
     */
    public function getAccountPass($id)
    {
        $Data = new QueryData();
        $Data->setMapClassName(AccountData::class);
        $Data->setLimit(1);

        $Data->setSelect('account_id, account_name, account_login, account_pass, account_key');
        $Data->setFrom('accounts');

        $queryWhere = AccountUtil::getAccountFilterUser($Data, $this->session);
        $queryWhere[] = 'account_id = ?';
        $Data->addParam($id);

        $Data->setWhere($queryWhere);

        return DbWrapper::getResults($Data);
    }

    /**
     * @param $id
     */
    public function getAccountPassHistory($id)
    {

    }

    /**
     * Incrementa el contador de vista de clave de una cuenta en la BBDD
     *
     * @param int $id
     * @return bool
     * @throws \SP\Core\Exceptions\QueryException
     * @throws \SP\Core\Exceptions\ConstraintException
     */
    public function incrementDecryptCounter($id)
    {
        $query = /** @lang SQL */
            'UPDATE accounts SET account_countDecrypt = (account_countDecrypt + 1) WHERE account_id = ? LIMIT 1';

        $Data = new QueryData();
        $Data->setQuery($query);
        $Data->addParam($id);

        return DbWrapper::getQuery($Data);
    }

    /**
     * Logs account action
     *
     * @param $id
     * @param $actionId
     */
    public function logAccountAction($id, $actionId)
    {
        $query = /** @lang SQL */
            'SELECT account_id, account_name, customer_name FROM account_data_v WHERE account_id = ? LIMIT 1';

        $Data = new QueryData();
        $Data->setQuery($query);
        $Data->addParam($id);

        $account = DbWrapper::getResults($Data);

        $Log = new Log();
        $LogMessage = $Log->getLogMessage();
        $LogMessage->setAction(__($actionId, false));
        $LogMessage->addDetails(__('ID', false), $id);
        $LogMessage->addDetails(__('Cuenta', false), $account->customer_name . ' / ' . $account->account_name);
        $Log->writeLog();
    }
}