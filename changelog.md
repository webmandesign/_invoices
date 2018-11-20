# Invoices Changelog

## 1.7.0

* **Update**: Redesigned

### Files changed:

	changelog.md
	footer.php
	header.php
	style.css
	assets/scss/style.scss
	templates/generator.php
	templates/parts/loop/loop.php


## 1.6.0

* **Add**: "Expense" custom post type
* **Add**: Option to override due period per invoice
* **Add**: Links to month and year archives
* **Add**: Date output helper methods
* **Update**: Localization

### Files changed:

	changelog.md
	style.css
	assets/scss/style.scss
	includes/class-advanced-custom-fields.php
	includes/class-helper.php
	includes/class-post-types.php
	languages/*.*
	templates/parts/component/anchors-invoice.php
	templates/parts/component/note-invoice.php
	templates/parts/meta/meta-invoice-dates.php


## 1.5.1

* **Add**: Expected net income calculation (66% of expected total payment)
* **Fix**: Not countable PHP error on `$atts['source']` in summary

### Files changed:

	changelog.md
	style.css
	assets/scss/style.scss
	languages/*.*
	templates/parts/component/summary.php


## 1.5.0

* **Add**: Separation between multiple invoice payment options
* **Add**: Functionality to print only main currency (not dual)
* **Update**: Fixer API
* **Update**: Localization

### Files changed:

	changelog.md
	footer.php
	style.css
	assets/scss/style.scss
	includes/class-advanced-custom-fields.php
	includes/class-customize.php
	includes/class-helper.php
	languages/*.*
	templates/parts/component/anchors-invoice.php
	templates/parts/component/note-invoice.php
	templates/parts/menu/menu-primary.php
	templates/parts/meta/meta-invoice-payment.php


## 1.4.1

* **Update**: Localization

### Files changed:

	changelog.md
	style.css
	includes/class-advanced-custom-fields.php
	languages/*.*


## 1.4.0

* **Add**: Product setup metabox
* **Add**: Expected payment calculation and display (on mouse hover and in summary)
* **Update**: Improving "Generator" page template description

### Files changed:

	changelog.md
	header.php
	style.css
	assets/scss/style.scss
	includes/class-advanced-custom-fields.php
	includes/class-helper.php
	templates/generator.php
	templates/parts/component/summary.php
	templates/parts/loop/loop-products.php
	templates/parts/meta/meta-invoice-total.php


## 1.3.0

* **Add**: Upload invoice attachments
* **Add**: Currency exchange info in screen summary
* **Add**: "Summary" and "Back to top" links to invoice anchors
* **Update**: Redesigning invoice to allow for more invoiced items (products)

### Files changed:

	changelog.md
	style.css
	assets/scss/style.scss
	includes/class-advanced-custom-fields.php
	templates/parts/component/anchors-invoice.php
	templates/parts/component/summary.php
	templates/parts/content/content-simple.php
	templates/parts/menu/menu-primary.php
	templates/parts/meta/meta-invoice-total.php


## 1.2.2

* **Fix**: Apply posts count only on front-end

### Files changed:

	changelog.md
	style.css
	assets/scss/style.scss
	includes/class-loop.php


## 1.2.1

* **Update**: Improving import XML file generator
* **Update**: Improving styles

### Files changed:

	changelog.md
	style.css
	assets/scss/style.scss
	includes/class-generator.php
	templates/parts/generator/generator-import.php
	templates/parts/generator/xml-footer.php
	templates/parts/generator/xml-header.php
	templates/parts/generator/xml-item.php


## 1.2.0

* **Add**: Import XML file generator (from CSV data)

### Files changed:

	changelog.md
	footer.php
	functions.php
	style.css
	assets/scss/style.scss
	includes/class-customize.php
	includes/class-generator.php
	includes/class-helper.php
	languages/*.*
	templates/generator.php
	templates/parts/generator/generator-import.php
	templates/parts/generator/generator-xml-footer.php
	templates/parts/generator/generator-xml-header.php
	templates/parts/generator/generator-xml-item.php


## 1.1.1

* **Update**: Improving theme options
* **Fix**: Invoice exchange rate info not displayed

### Files changed:

	changelog.md
	style.css
	includes/class-customize.php
	templates/parts/component/note-invoice.php


## 1.1.0

* **Add**: Option to select default values for Invoice custom fields
* **Add**: Option to select form field type for Invoice Clients
* **Update**: Improving code organization
* **Update**: Making currency exchange info a link to API data
* **Update**: Localization
* **Fix**: Print styles

### Files changed:

	changelog.md
	functions.php
	style.css
	assets/scss/style.scss
	includes/class-advanced-custom-fields.php
	includes/class-customize.php
	includes/class-post-types.php
	includes/class-taxonomies.php
	languages/*.*
	templates/parts/component/note-invoice.php
	templates/parts/loop/loop-products.php


## 1.0.0

* Initial release.
