<?
/**
* @package Boz_Orders
*/


	interface GatewayInterface {
		function hasFeature($key);
		function getFeatures();
	}
	interface CardGatewayInterface {
		function process($order);
		function process3DAuth($order);
		function refund($order);
	}
	interface SubscriptionInterface extends CardGatewayInterface {
		function createSubscription($order);
		function getSubscription($order);
		function updateSubscription($order);
		function cancelSubscription($order);
	}
	interface FormGatewayInterface {
		function redirectForm($order,$returnUrl);
		function handleFormReturn($order);
		function callback();
		function getPaymentMethods($orderTotal);
		function getFeatures();
		function hasFeature($key);
	}
?>
