<?php 

return [
	'maternal' => [
		'maternal_counselling' => [
			// [
			// 	'model'		=> 'CcMrCounsellingAnc',
			// 	'table'		=> 'cc_mr_counselling_anc',
			// 	'server'	=> 'community',
			// 	'api_id'	=> 'WfrGlt9gYxW.YF2ivOyo5'
			// ],
			[
				'name'		=> 'Maternal Counselling',
				'model'		=> 'CcMrAncNutriCounsel',
				'table'		=> 'cc_mr_anc_nutri_counsel',
				'server'	=> 'community',
				'api_id'	=> 'c0zIiLT97P4',
			],
		],
		'plw_who_receive_ifas' => [
			[
				'name'		=> 'PLW who receive IFAS',
				'model'		=> 'CcMrAncIfaDistribution',
				'table'		=> 'cc_mr_anc_ifa_distribution',
				'server'	=> 'community',
				'api_id'	=> 'D9jDxIOFAwV'
			],
		],
		'pregnant_women_weighed' => [
			[
				'name'		=> 'Pregnant women weighed',
				'model'		=> 'CcMrWeightInKgAnc',
				'table'		=> 'cc_mr_weight_in_kg_anc',
				'server'	=> 'community',
				'api_id'	=> 'WfrGlt9gYxW.OJd05AWCFTk'
			],
		],
		'exclusive_breastfeeding' => [
			[
				'name'  	=> 'Increase in exclusive breastfeeding',
				'model'		=> 'CcCrExclusiveBreastFeeding',
				'table'		=> 'cc_cr_exclusive_breast_feeding',
				'server'	=> 'community',
				'api_id'	=> 'jxtGrMi58Zx'	
			]
		]
	],
	'child' => [
		'iycf_counselling' => [
			[
				'name'		=> 'Imci Counselling',
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
		'child_growth_monitoring' => [
		],
		'vitamin_a_supplementation' => [
			[
				'name'		=> 'Food Supplimentation',
				'model'		=> 'CcCrAdditionalFoodSupplimentation',
				'table'		=> 'cc_cr_additional_food_supplimentation',
				'server'	=> 'https://communitydhis.mohfw.gov.bd/nationalcc/api/',
				'api_id'	=> 'gpJQzatKvmH'	
			],
		]
	],
	'outcomes' => [
		'imci_stunting' => [
			[
				'model'		=> 'ImciStunting',
				'table'		=> 'imci_stunting',
				'server'	=> 'central',
				'api_id'	=> 'QCGhrXxmJDb'	
			],
		],
		'imci_stunting_percent' => [
			[
				'model'		=> 'ImciStuntingPercent',
				'table'		=> 'imci_stunting_percent',
				'server'	=> 'central',
				'source'  => 'DGHS',
				'api_id'	=> 'Pd6AH5koIb3'	
			],
		],
		'imci_wasting' => [
			[
				'model'		=> 'ImciWasting',
				'table'		=> 'imci_wasting',
				'server'	=> 'central',
				'api_id'	=> 'JBhv2WOYxSf'	
			],
		],
		'imci_wasting_percent' => [
			[
				'model'		=> 'ImciWastingPercent',
				'table'		=> 'imci_wasting_percent',
				'server'	=> 'central',
				'source'  => 'DGHS',
				'api_id'	=> 'wzLKMAyhQPp'	
			],
		],
		'exclusive_breastfeeding' => [
			'cc_cr_exclusive_breast_feeding' => [
				'model'		=> 'CcCrExclusiveBreastFeeding',
				'table'		=> 'cc_cr_exclusive_breast_feeding',
				'server'	=> 'community',
				'source'  	=> 'DGHS',
				'api_id'	=> 'jxtGrMi58Zx'	
			],
			'imci_exclusice_breast_feeding' => [
				'model'		=> 'ImciExclusiveBreastFeeding',
				'table'		=> 'imci_exclusice_breast_feeding',
				'server'	=> 'central',
				'source' 	=> 'DGHS',
				'api_id'	=> 'LSNFSyDR2Ec'	
			],
		]
	]

];