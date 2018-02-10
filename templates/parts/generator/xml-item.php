<?php
/**
 * Import XML file content: Item
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.2.0
 * @version  1.2.1
 */





?>

<item>

	<!-- DYNAMIC IMPORT DATA: -->

		<title>{{$title}}</title>
		<wp:post_date><![CDATA[{{$date}}]]></wp:post_date>

		<!-- Value: float -->
		<wp:postmeta>
			<wp:meta_key><![CDATA[invoice_total]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$total}}]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[products_0_price]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$total}}]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[products_0_total]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$total}}]]></wp:meta_value>
		</wp:postmeta>

		<!-- Value: absint, post ID -->
		<wp:postmeta>
			<wp:meta_key><![CDATA[products_0_product]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$product}}]]></wp:meta_value>
		</wp:postmeta>

		<!-- Value: text -->
		<wp:postmeta>
			<wp:meta_key><![CDATA[products_0_description]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$sales}}]]></wp:meta_value>
		</wp:postmeta>

		<!-- Value: absint, taxonomy term ID -->
		<wp:postmeta>
			<wp:meta_key><![CDATA[seller]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$seller_id}}]]></wp:meta_value>
		</wp:postmeta>
		<category domain="category" nicename="{{$seller_slug}}"></category>

		<!-- Value: absint, taxonomy term ID -->
		<wp:postmeta>
			<wp:meta_key><![CDATA[client]]></wp:meta_key>
			<wp:meta_value><![CDATA[{{$client_id}}]]></wp:meta_value>
		</wp:postmeta>
		<category domain="client" nicename="{{$client_slug}}"></category>

		<!-- Value: absint, taxonomy term ID -->
		<wp:postmeta>
			<wp:meta_key><![CDATA[payment_method]]></wp:meta_key>
			<wp:meta_value><![CDATA[a:1:{i:0;s:1:"{{$payment_method_id}}";}]]></wp:meta_value>
		</wp:postmeta>
		<category domain="payment_method" nicename="{{$payment_method_slug}}"></category>

	<!-- STATIC IMPORT DATA: -->

		<wp:post_type><![CDATA[post]]></wp:post_type>
		<wp:status><![CDATA[publish]]></wp:status>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_invoice_total]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_total]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[products]]></wp:meta_key>
			<wp:meta_value><![CDATA[1]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_products]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_products]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_products_0_price]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_products_price]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[products_0_quantity]]></wp:meta_key>
			<wp:meta_value><![CDATA[1]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_products_0_quantity]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_products_quantity]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_products_0_product]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_products_product]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_products_0_description]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_products_description]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_products_0_total]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_products_total]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_seller]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_setup_seller]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_client]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_setup_client]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_payment_method]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_setup_payment_method]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[symbol_constant]]></wp:meta_key>
			<wp:meta_value><![CDATA[308]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_symbol_constant]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_setup_symbol_constant]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[exchange_from]]></wp:meta_key>
			<wp:meta_value><![CDATA[USD]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_exchange_from]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_exchange_exchange_from]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[exchange_to]]></wp:meta_key>
			<wp:meta_value><![CDATA[EUR]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_exchange_to]]></wp:meta_key>
			<wp:meta_value><![CDATA[key_invoice_exchange_exchange_to]]></wp:meta_value>
		</wp:postmeta>

		<wp:postmeta>
			<wp:meta_key><![CDATA[IMPORTED]]></wp:meta_key>
			<wp:meta_value><![CDATA[FROM_GENERATED_XML]]></wp:meta_value>
		</wp:postmeta>

</item>
