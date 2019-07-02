<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;

/**
 * 
 */
class CreatePlan extends Paypal
{
	
	
	public function create()
	{


			$plan = $this->Plan();
		    $paymentDefinition = $this->PaymentDefinition();
			$chargeModel = $this->ChargeModel();
			$paymentDefinition->setChargeModels(array($chargeModel));
			$merchantPreferences = $this->MerchantPreferences();
			$plan->setPaymentDefinitions(array($paymentDefinition));
			$plan->setMerchantPreferences($merchantPreferences);
			$output = $plan->create($this->apiContext);

	}

	protected function Plan()
	{
		$plan = new Plan();
		$plan->setName('T-Shirt of the Month Club Plan')
		     ->setDescription('Template creation.')
		     ->setType('fixed');

		return $plan;
	}

	protected function paymentDefinition()
	{
		$paymentDefinition = new PaymentDefinition();
	    $paymentDefinition->setName('Regular Payments')
						    ->setType('REGULAR')
						    ->setFrequency('Month')
						    ->setFrequencyInterval("2")
						    ->setCycles("12")
						    ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));

		return $paymentDefinition;
	}

	protected function chargeModel()
	{
		$chargeModel = new ChargeModel();
		$chargeModel->setType('SHIPPING')
		    		->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));

		return $chargeModel;
	}

	protected function merchantPreferences()
	{
		$merchantPreferences = new MerchantPreferences();
			

		$merchantPreferences->setReturnUrl(config('services.paypal.url.executeAgreement.success'))
						    ->setCancelUrl(config('services.paypal.url.executeAgreement.failure'))
						    ->setAutoBillAmount("yes")
						    ->setInitialFailAmountAction("CONTINUE")
						    ->setMaxFailAttempts("0")
						    ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

		return $merchantPreferences;
	}


}