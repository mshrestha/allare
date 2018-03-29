<?php 

return [
	'maternal' => [
		'maternal_counselling' => [
			'cc_mr_counselling_anc' => [
				'model'		=> 'CcMrCounsellingAnc',
				'table'		=> 'cc_mr_counselling_anc',
				'server'	=> 'community',
				'api_id'	=> 'WfrGlt9gYxW.YF2ivOyo5'
			],
			'cc_mr_anc_nutri_counsel' => [
				'model'		=> 'CcMrAncNutriCounsel',
				'table'		=> 'cc_mr_anc_nutri_counsel',
				'server'	=> 'community',
				'api_id'	=> 'c0zIiLT97P4',
			],
		],
		'plw_who_receive_ifas' => [
			[
				'model'		=> 'CcMrAncIfaDistribution',
				'table'		=> 'cc_mr_anc_ifa_distribution',
				'server'	=> 'community',
				'api_id'	=> 'D9jDxIOFAwV'
			],
		],
		'pregnant_women_weighed' => [
			[
				'model'		=> 'CcMrWeightInKgAnc',
				'table'		=> 'cc_mr_weight_in_kg_anc',
				'server'	=> 'community',
				'api_id'	=> 'WfrGlt9gYxW.OJd05AWCFTk'
			],
		]
	],
	'child' => [
		'child_growth_monitoring' => [
		],
		'iycf_counselling' => [
			[
				'model'		=> 'ImciCounselling',
				'table'		=> 'imci_counselling',
				'server'	=> 'central',
				'api_id'	=> 'RN4w5hxGHRk'
			],
			[
				'model'		=> 'ImciFemale',
				'table'		=> 'imci_female',
				'server'	=> 'central',
				'api_id'	=> 'CRZkTTALRSb'
			],
			[
				'model'		=> 'ImciMale',
				'table'		=> 'imci_male',
				'server'	=> 'central',
				'api_id'	=> 'Fnsa8A43USl'
			]
		],
		'vitamin_a_supplementation' => [
			'cc_cr_additional_food_supplimentation' => [
				'model'		=> 'CcCrAdditionalFoodSupplimentation',
				'table'		=> 'cc_cr_additional_food_supplimentation',
				'server'	=> 'https://communitydhis.mohfw.gov.bd/nationalcc/api/',
				'api_id'	=> 'gpJQzatKvmH'	
			],
		]
	],
	
	'imci_stunting' => [
		[
			'model'		=> 'ImciStunting',
			'table'		=> 'imci_stunting',
			'server'	=> 'central',
			'api_id'	=> 'QCGhrXxmJDb'	
		],
	],
	'imci_wasting' => [
		[
			'model'		=> 'ImciWasting',
			'table'		=> 'imci_wasting',
			'server'	=> 'central',
			'api_id'	=> 'JBhv2WOYxSf'	
		],
	]

];