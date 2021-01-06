<?php

namespace ThalamusSDK;

/**
 * 
 * @author saila
 *
 */
class ThalamusErrors {
	/**
	 * errores exception list
	 *
	 * @var array errors
	 */
	public static $errors = array (
				
			// ------------CODE--CODE-THALAMUS----------------------------------MESSAGE-THALAMUS-----------------------------------------------------ERROR NAME-----------------------------ERROR DESCRIPTION----------------------
				
			// 0XXX RESERVADO (?)
				
			array (
					900,
					"error.message",
					"UNAUTHORIZED",
					"UNAUTHORIZED",
					"401 Unauthorized"
			),
			array (
					901,
					"error.code",
					"401",
					"UNAUTHORIZED",
					"401 Unauthorized"
			),

			// 1XXX PERSON
				
			// 10XX -
			array (
					1001,
					"execution",
					"PartyAlreadyLoggedin",
					"PARTY_ALREADY_LOGGED_ID",
					""
			),
			array (
					1002,
					"execution.execution",
					"execution.execution: The party is already logged in.",
					"PARTY_ALREADY_LOGGED_ID",
					""
			),
				
			// 11XX - LOGIN
				
			array (
					1100,
					"error.message",
					"NOT_FOUND",
					"USER_NOT_FOUND",
					"Usuario o contraseña incorrectos"
			),
			array (
					1101,
					"error.code",
					"404",
					"USER_NOT_FOUND",
					"Usuario o contraseña incorrectos"
			),
			array (
					1102,
					"error.description",
					"%",
					"UNAUTHORIZED",
					"401 Unauthorized"
			),
			array (
					1103,
					"error.description",
					"User is disabled",
					"AGE_IDENTITY_VALIDATION_FAIL",
					"Usuario no valido"
			),
				
			// 12XX - REGISTER / UPDATE
				
			array (
					1200,
					"error.message",
					"InvalidJson",
					"INVALID_JSON",
					"Invalid Json"
			),
			array (
					1201,
					"error.invalid.credentials",
					"The following credential already exists: email",
					"CREDENTIAL_EMAIL_ALREADY_EXISTS",
					"The following credential already exists: email"
			),
			array (
					1202,
					"error.invalid.credentials",
					"La siguiente credencial ya existe: email",
					"CREDENTIAL_EMAIL_ALREADY_EXISTS",
					"The following credential already exists: email"
			),
			array (
					1203,
					"execution.credential.principal_Principal",
					"This credential already exists.",
					"CREDENTIAL_ALREADY_EXISTS",
					""
			),
			array (
					1204,
					"credential",
					"NotMatchAnyPrincipal",
					"WRONG_CREDENTIALS",
					""
			),
			array (
					1205,
					"credential",
					"NoCredentialsProvided",
					"CREDENTIALS_REQUIRED",
					""
			),
			array (
					1206,
					"error.invalid.credentials",
					"The following credential already exists: cellphone",
					"CREDENTIAL_CELLPHONE_ALREADY_EXISTS",
					"The following credential already exists: cellphone"
			),
			array (
					1213,
					"error.invalid.credentials",
					"The following credential already exists: document",
					"CREDENTIAL_DOCUMENT_ALREADY_EXISTS",
					"The following credential already exists: document"
			),
			array (
					1214,
					"execution.unexpected",
					"INTERNAL_SERVER_ERROR",
					"INTERNAL_SERVER_ERROR",
					""
			),
			array (
					1215,
					"credential.password",
					"InvalidPassword",
					"INVALID_PASSWORD",
					""
			),
			array (
					1216,
					"error.principal.required",
					"At least one of this principal fields are needed: username,document,email,CPerson2,cper,C1Test,MPRTest01,CredTest",
					"PRINCIPAL_REQUIRED",
					""
			),
			// CONSUMER
			array (
					1224,
					"consumer",
					"MissingField",
					"CONSUMERS_REQUIRED",
					"No se admite consumer"
			),
			array (
					1225,
					"execution.consumer",
					"execution.consumer: error.MissingField",
					"CONSUMERS_REQUIRED",
					"No se admite consumer"
			),
				
			// PROFILE
				
			array (
					1230,
					"email",
					"invalidEmail",
					"PROFILE_EMAIL_INVALID_FORMAT",
					""
			),
			array(
					1231,
					"profile.birthday",
					"MissingValidationData",
					"PROFILE_BIRTHDAY_MISMATCH",
					""
			),
			array(
					1232,
					"profile.birthday",
					"Minor",
					"PERSON_IS_MINOR",
					""
			),
			array(
					1233,
					"profile.birdthDate",
					"Age should be at least 18",
					"PERSON_IS_MINOR",
					""
			),
			array(
					1234,
					"profile.document",
					"MissingMinorInformation",
					"DOCUMENT_MISMATCH",
					""
			),
			array(
					1235,
					"profile.document",
					"MissingInformation",
					"DOCUMENT_MISMATCH",
					""
			),
			array(
					1236,
					"profile.document",
					"Required",
					"DOCUMENT_REQUIRED",
					""
			),
			array (
					1237,
					"birthday",
					"minor.registration.birthday.required",
					"PERSON_IS_MINOR",
					""
			),
			array (
					1238,
					"execution.birthday",
					"Date of Birth: Required to validate registrant's legal age.",
					"PERSON_IS_MINOR",
					""
			),
			array (
					1239,
					"profile.birdthDate",
					"Age should be at least %",
					"PERSON_IS_MINOR",
					""
			),
			array (
					1240,
					"execution.profile.birdthDate",
					"Date of Birth: Age should be at least %",
					"PERSON_IS_MINOR",
					""
			),
				
			// CELLPHONE
			array (
					1245,
					"intCode",
					"InvalidCellInternationalCode",
					"CELLPHONE_INTCODE_INVALID_FORMAT",
					""
			),
			array (
					1246,
					"profile.cellphone.intCode",
					"InvalidFormat",
					"CELLPHONE_INTCODE_INVALID_FORMAT",
					""
			),
			array (
					1247,
					"execution.profile.cellphone.intCode",
					"execution.profile.cellphone.intCode: error.InvalidFormat",
					"CELLPHONE_INTCODE_INVALID_FORMAT",
					""
			),
			array (
					1248,
					"areaCode",
					"InvalidCellAreaCode",
					"CELLPHONE_AREACODE_INVALID_FORMAT",
					""
			),
			array (
					1252,
					"profile.cellphone.areaCode",
					"InvalidFormat",
					"CELLPHONE_AREACODE_INVALID_FORMAT",
					""
			),
			array (
					1253,
					"execution.profile.cellphone.areaCode",
					"execution.profile.cellphone.areaCode: error.InvalidFormat",
					"CELLPHONE_AREACODE_INVALID_FORMAT",
					""
			),
			array (
					1254,
					"profile.cellphone.number",
					"InvalidFormat",
					"CELLPHONE_NUMBER_INVALID_FORMAT",
					""
			),
			array (
					1255,
					"execution.profile.cellphone.number",
					"execution.profile.cellphone.number: error.InvalidFormat",
					"CELLPHONE_NUMBER_INVALID_FORMAT",
					""
			),
			array (
					1256,
					"number",
					"InvalidCellPhoneNumber",
					"CELLPHONE_NUMBER_INVALID_FORMAT",
					""
			),
				
			// PHONE
			array (
					1257,
					"profile.phone.type",
					"InvalidFormat",
					"PHONE_TYPE_INVALID_FORMAT",
					""
			),
			array (
					1258,
					"execution.profile.phone.type",
					"execution.profile.phone.type: error.InvalidFormat",
					"PHONE_TYPE_INVALID_FORMAT",
					""
			),
			array (
					1259,
					"profile.phone.number",
					"InvalidFormat",
					"PHONE_NUMBER_INVALID_FORMAT",
					"Invalid format profile phone number"
			),
			array (
					1260,
					"profile.phone.number",
					"InvalidPhoneNumber",
					"PHONE_NUMBER_INVALID_FORMAT",
					"Invalid format profile phone number"
			),
			array (
					1261,
					"profile.phone.intCode",
					"InvalidFormat",
					"PHONE_INTCODE_INVALID_FORMAT",
					"Invalid format profile phone intCode"
			),
			array (
					1262,
					"execution.profile.phone.intCode",
					"execution.profile.phone.intCode: error.InvalidFormat",
					"PHONE_INTCODE_INVALID_FORMAT",
					"Invalid format profile phone intCode"
			),
			array (
					1263,
					"profile.phone.areaCode",
					"InvalidFormat",
					"PHONE_AREACODE_INVALID_FORMAT",
					""
			),
			array (
					1264,
					"execution.profile.phone.areaCode",
					"InvalidFormat",
					"PHONE_AREACODE_INVALID_FORMAT",
					""
			),
				
			// ADDRESS
			array (
					1265,
					"profile.address.stateOrProvinceId",
					"InvalidFormat",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),

			array (
					1266,
					"execution.profile.address.stateOrProvinceId",
					"execution.profile.address.stateOrProvinceId: error.InvalidFormat",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),
			array (
					1267,
					"profile.address.countryId",
					"InvalidFormat",
					"ADDRESS_COUNTRY_ID_INVALID_FORMAT",
					""
			),
			array (
					1268,
					"profile.address.countryId",
					"InvalidId",
					"ADDRESS_COUNTRY_ID_INVALID_ID",
					""
			),
			array (
					1269,
					"execution.profile.address.countryId",
					"execution.profile.address.countryId: error.InvalidFormat",
					"ADDRESS_COUNTRY_ID_INVALID_FORMAT",
					""
			),
			array (
					1270,
					"profile.address.street1",
					"InvalidFormat",
					"ADDRESS_STREET1_INVALID_FORMAT",
					""
			),
			array (
					1271,
					"profile.address.street2",
					"InvalidFormat",
					"ADDRESS_STREET2_INVALID_FORMAT",
					""
			),
			array (
					1272,
					"profile.address.city",
					"InvalidFormat",
					"ADDRESS_CITY_INVALID_FORMAT",
					""
			),
			array (
					1273,
					"execution.profile.address.city",
					"execution.profile.address.city: error.InvalidFormat",
					"ADDRESS_CITY_INVALID_FORMAT",
					""
			),
			array (
					1274,
					"profile.address.postalCode",
					"InvalidFormat",
					"ADDRESS_POSTALCODE_INVALID_FORMAT",
					""
			),
			array (
					1275,
					"execution.profile.address.postalCode",
					"execution.profile.address.postalCode: error.InvalidFormat",
					"ADDRESS_POSTALCODE_INVALID_FORMAT",
					""
			),
			array (
					1276,
					"profile.address.type",
					"InvalidFormat",
					"ADDRESS_TYPE_INVALID_FORMAT",
					""
			),
			array (
					1277,
					"execution.profile.address.type",
					"execution.profile.address.type: error.InvalidFormat",
					"ADDRESS_TYPE_INVALID_FORMAT",
					""
			),
				
			array (
					1278,
					"profile.address.countryId",
					"Required",
					"ADDRESS_COUNTRY_ID_REQUIRED",
					""
			),
			array (
					1279,
					"execution.profile.address.countryId",
					"execution.profile.address.countryId: This field is required.",
					"ADDRESS_COUNTRY_ID_REQUIRED",
					""
			),
			array (
					1280,
					"profile.address.stateId_InvalidId",
					"InvalidId",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),
			array (
					1281,
					"execution.profile.address.stateId_execution.profile.address.stateId: error.InvalidId",
					"execution.profile.address.stateId: error.InvalidId",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),
			array (
					1282,
					"profile.address.stateId",
					"InvalidId",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),
			array (
					1283,
					"execution.profile.address.stateId_execution.profile.address.stateId: error.InvalidId",
					"execution.profile.address.stateId: error.InvalidId",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),
			array (
					1284,
					"execution.profile.address.stateId_execution.profile.address.stateId: error.InvalidId",
					"execution.profile.address.stateId: error.InvalidId",
					"ADDRESS_STATE_ID_INVALID_FORMAT",
					""
			),

			//optins
			array (
					1285,
					"optIns",
					"InvalidOptIns",
					"OPTINS_INVALID_FORMAT",
					""
			),
			// 13XX - PASSWORD ( CHANGE / REQUEST RESET / RESET )
				
			// PASSWORD CHANGE
				
			array (
					1301,
					"oldPassword",
					"oldNotMatch",
					"OLD_PASSWORD_NOT_MATCH",
					"Old Password: The password don't match with actual password."
			),
			array (
					1302,
					"execution.oldPassword",
					"Old Password: The password don't match with actual password.",
					"OLD_PASSWORD_NOT_MATCH",
					"Old Password: The password don't match with actual password."
			),
			array (
					1303,
					"partyCredential.plainPassword",
					"InvalidPassword",
					"PLAIN_PASSWORD_INVALID",
					""
			),
			array (
					1304,
					"confirmPassword",
					"NotMatch",
					"CONFIRM_PASSWORD_NOT_MATCH",
					"Confirm Password: Passwords do not match."
			),
			array (
					1305,
					"execution.confirmPassword",
					"Confirm Password: Passwords do not match.",
					"CONFIRM_PASSWORD_NOT_MATCH",
					"Confirm Password: Passwords do not match."
			),
			array (
					1306,
					"newpassword",
					"EqualsOldPassword",
					"NEW_PASSWORD_EQUALS_OLD_PASSWORD",
					"Equals Old Password."
			),
			array (
					1307,
					"execution.newpassword",
					"execution.newpassword: New password must be different from previous password.",
					"NEW_PASSWORD_EQUALS_OLD_PASSWORD",
					"execution.newpassword: New password must be different from previous password."
			),

			// PASSWORD CONFIRMATION
				
			array (
					1310,
					"error.message",
					"Unauthorized",
					"UNAUTHORIZED",
					""
			),
				
			// REQUEST RESET PASSWORD
				
			array (
					1320,
					"execution",
					"InvalidPrincipal",
					"REQUEST_PASSWORD_RESET_INVALID_PRINCIPAL",
					""
			),
				
			// RESET PASSWORD
				
			array (
					1330,
					"execution.token",
					"execution.token: The token is invalid.",
					"RESET_PASSWORD_INVALID_TOKEN",
					""
			),
			array (
					1331,
					"token",
					"InvalidToken",
					"RESET_PASSWORD_INVALID_TOKEN",
					""
			),
			array (
					1332,
					"partyCredential.plainPassword",
					"InvalidPassword",
					"RESET_PASSWORD_INVALID_PASSWORD",
					""
			),
			array (
					1333,
					"principal",
					"InvalidPrincipal",
					"RESET_PASSWORD_INVALID_PRINCIPAL",
					""
			),
			array (
					1334,
					"execution.principal",
					"execution.principal: Invalid Principal",
					"RESET_PASSWORD_INVALID_PRINCIPAL",
					""
			),
				
			// 14XX -
			// 15XX -
			// 16XX - INBOX
				
			// READ
			array (
					1601,
					"id",
					"InvalidId",
					"INBOX_INVALID_ID",
					""
			),
			array (
					1602,
					"read",
					"required",
					"INBOX_REQUIRED_READ",
					""
			),
			array (
					1603,
					"messageInbox",
					"invalidId",
					"INBOX_INVALID_ID",
					""
			),
			array (
					1604,
					"messageInbox",
					"alreadyRead",
					"INBOX_ALREADY_READ",
					""
			),
				
			// 17XX - FIRE INTERACTIONS
				
			array (
					1701,
					"interaction",
					"InvalidCode",
					"FIRE_INTERACTION_INVALID_TYPE_CODE",
					""
			),
				
			array (
					1702,
					"interactionType",
					"InvalidCode",
					"FIRE_INTERACTION_INVALID_CODE",
					""
			),
				
			array (
					1703,
					"execution.interactionType",
					"execution.interactionType: This field allows letters only. (up to 10 characters)",
					"FIRE_INTERACTION_INVALID_TYPE_CODE",
					"This field allows letters only. (up to 10 characters)"
			),
				
			// 18XX - AVATAR
				
			// ACTIVITY LOGIN
			array (
					1801,
					"activity",
					"InvalidCode",
					"ACTIVITY_INVALID_CODE",
					""
			),
				
			// AVATAR CREATE
				
			array (
					1802,
					"file",
					"empty.file",
					"AVATAR_EMPTY_FILE",
					""
			),
			array (
					1803,
					"execution.unexpected",
					"INTERNAL_SERVER_ERROR",
					"INTERNAL_SERVER_ERROR",
					""
			),
				
			// AVATAR UPDATE
				
			array (
					1804,
					"avatar",
					"IncorrectBody",
					"AVATAR_INCORRECT_BODY",
					""
			),
				
			// 19XX -
				
			// 2XXX ACTIVITY
				
			// 20XX -
			array (
					2100,
					"activity",
					"InvalidCode",
					"ACTIVITY_INVALID_CODE",
					""
			),
				
			// 21XX - GENERIC
			// 22XX - EVENTS
				
			// PARTY ATTENDANCE
				
			array (
					2201,
					"activity",
					"AssistanceDateExpired",
					"EVENT_ATTENDANCE_DATE_EXPIRED",
					""
			),
			array (
					2202,
					"activity",
					"NotOcurred",
					"EVENT_ATTENDANCE_NOT_OCCURED",
					""
			),
			array (
					2203,
					"invitation",
					"NotAccepted",
					"EVENT_ATTENDANCE_INVITATION_NOT_ACCEPTED",
					""
			),
			array (
					2204,
					"invitation",
					"AlreadyRegisteredAssistance",
					"EVENT_ATTENDANCE_ALREADY_REGISTERED",
					""
			),
			array (
					2205,
					"execution.invitation",
					"Invitation: error.AlreadyRegisteredAssistance",
					"EVENT_ATTENDANCE_ALREADY_REGISTERED",
					""
			),
				
			// ACCEPT/DECLINE INVITATION
				
			array (
					2010,
					"activity",
					"AcceptanceDateExpired",
					"EVENT_ACCEPTANCE_DATA_EXPIRED",
					""
			),
			array (
					2011,
					"activity",
					"CodeRequired",
					"EVENT_ACCEPTANCE_CODE_REQUIRED",
					""
			),
			array (
					2012,
					"activity",
					"AttendanceLimitReached",
					"EVENT_ACCEPTANCE_LIMIT_REACHED",
					""
			),
			array (
					2013,
					"ticketCode",
					"InvalidCode",
					"EVENT_ACCEPTANCE_INVALID_CODE",
					""
			),
			array (
					2014,
					"invitation",
					"AlreadyRegisteredAcceptance",
					"EVENT_ACCEPTANCE_ALREADY_REGISTERED",
					""
			),
				
			// ACCEPT INVITATION WITHOUT LOGIN
				
			array (
					2020,
					"activity",
					"Inactive",
					"EVENT_ACCEPTANCE_INACTIVE",
					""
			),
			array (
					2023,
					"invitation",
					"InvalidToken",
					"EVENT_ACCEPTANCE_INVALID_TOKEN",
					""
			),
			array (
					2024,
					"invitation",
					"InvalidCode",
					"EVENT_ACCEPTANCE_INVALID_CODE",
					""
			),
				
			// 23XX - SURVEY
			array (
					2300,
					"survey",
					"completed",
					"SURVEY_COMPLETED",
					"Survey Completed"
			),
				
			array (
					2301,
					"execution.survey",
					"execution.survey: error.completed",
					"SURVEY_COMPLETED",
					"Survey Completed"
			),
				
			// 24XX - MILEAGE
				
			array (
					2401,
					"item",
					"InvalidID",
					"ITEM_INVALID_ID",
					""
			),
				
			// GET CATALOG ITEMS / GET CATALOG ITEM / GET CART / GET CART ITEMS / GET CART TOTAL
				
			array (
					2402,
					"filter",
					"InvalidPageAndSize",
					"MILEAGE_CATALOG_INVALID_PAGE_SIZE",
					""
			),
			array (
					2403,
					"tags",
					"InvalidFormat",
					"MILEAGE_CATALOG_INVALID_TAGS",
					""
			),
			array (
					2404,
					"orderby",
					"InvalidFormat",
					"MILEAGE_CATALOG_INVALID_ORDERBY",
					""
			),
			array (
					2405,
					"item",
					"InvalidCode",
					"MILEAGE_CATALOG_INVALID_CODE",
					""
			),
			array (
					2406,
					"execution.item",
					"Item/s: This field allows letters only. (up to 10 characters)",
					"MILEAGE_CATALOG_INVALID_CODE",
					""
			),
				
			// ADD ITEM/S TO CART / UPDATE ITEM QUANTITY / REMOVE ITEM FROM CART / REMOVE ITEMS FROM CART
				
			array (
					2430,
					"account",
					"NotEnoughPoints",
					"MILEAGE_CART_ACCOUNT_NOT_ENOUGH_POINTS",
					""
			),
			array (
					2431,
					"item",
					"AnyItemToDelete",
					"MILEAGE_CART_ANY_ITEM_TO_DELETE",
					""
			),
			array (
					2432,
					"execution.item",
					"Item/s: error.AnyItemToDelete",
					"MILEAGE_CART_ANY_ITEM_TO_DELETE",
					""
			),
				
			// LOAD CODES
				
			array (
					2440,
					"activity",
					"CouponInputDateExpired",
					"LOAD_CODES_COUPON_DATE_EXPIRED",
					""
			),
			array (
					2441,
					"activity",
					"UserBanned",
					"LOAD_CODES_USER_BANNED",
					""
			),
			array (
					2442,
					"activity",
					"AllowedPublicCodesLimitReached",
					"LOAD_CODES_PUBLIC_CODES_LIMIT_REACHED",
					""
			),
			array (
					2443,
					"activity",
					"AllowedPublicPointsLimitReached",
					"LOAD_CODES_PUBLIC_POINTS_LIMIT_REACHED",
					""
			),
			array (
					2444,
					"activity",
					"CodesToRedeemLimitReached",
					"LOAD_CODES_TO_REDEEM_LIMIT_REACHED",
					""
			),
			array (
					2445,
					"codes",
					"IsEmpty",
					"LOAD_CODES_IS_EMPTY",
					""
			),
			array (
					2446,
					"InvalidCodes",
					"[all_invalid_codes]",
					"LOAD_CODES_ALL_INVALID_CODES",
					""
			),
			array (
					2447,
					"code",
					"codeAlreadyUsed",
					"LOAD_CODES_ALREADY_USED",
					""
			),
			array (
					2448,
					"execution.code",
					"Code: error.codeAlreadyUsed",
					"LOAD_CODES_ALREADY_USED",
					""
			),

			// GET ACCOUNT MOVEMENTS / MAKE CHECKOUT
				
			array (
					2460,
					"activity",
					"CheckoutLimitReached",
					"MILEAGE_CHECKOUT_LIMIT_REACHED",
					""
			),
			array (
					2461,
					"cart",
					"IsEmpty",
					"MILEAGE_CART_IS_EMPTY",
					""
			),
			array (
					2462,
					"execution.cart",
					"Cart: Empty.",
					"MILEAGE_CART_IS_EMPTY",
					""
			),
			array (
					2463,
					"item",
					"NotInStock",
					"MILEAGE_ITEM_NOT_IN_STOCK",
					""
			),
			array (
					2464,
					"item",
					"NotAvailable",
					"MILEAGE_ITEM_NOT_AVAILABLE",
					""
			),
			array (
					2465,
					"item",
					"CheckoutLimitReached",
					"MILEAGE_ITEM_CHEKOUT_LIMIT_REACHED",
					""
			),
			array (
					2466,
					"address",
					"InvalidCode",
					"MILEAGE_ADDRESS_INVALID_CODE",
					""
			),
			array (
					2467,
					"profile",
					"IncompleteAddress",
					"MILEAGE_PROFILE_INCOMPLETE_ADDRESS",
					""
			),
			array (
					1268,
					"execution.profile",
					"Profile: The address is incomplete.",
					"MILEAGE_PROFILE_INCOMPLETE_ADDRESS",
					""
			),
			array (
					2469,
					"checkout",
					"NotUniqueDeliveryMethod",
					"MILEAGE_NOT_UNIQUE_DELIVERY_METHOD",
					""
			),
			array (
					2470,
					"checkout",
					"NotSpecifiedDeliveryMethod",
					"MILEAGE_NOT_SPECIFIED_DELIVERY_METHOD",
					""
			),
			array (
					2471,
					"exchangeCenter",
					"InvalidID",
					"MILEAGE_EXCHANGE_CENTER_INVALID_ID",
					""
			),
				
			// GET ORDERS / GET ORDER
				
			array (
					2480,
					"order",
					"InvalidNumber",
					"MILEAGE_ORDER_INVALID_NUMBER",
					""
			),
				
			// GET EXCHANGE CENTERS / GET EXCHANGE CENTER
				
			array (
					2481,
					"exchangeCenter",
					"InvalidID",
					"MILEAGE_EXCHANGECENTER_INVALID_ID",
					""
			),
				
			// GET RANKING / GET RANKINGS / MARK ORDER AS DELIVERED OR CONTECT US
				
			// 25XX -
			// 26XX - GAMIFICATION
				
			// GET RANKING
				
			// GET RANKINGS
				
			// 27XX -
			// 28XX -
			// 29XX -
				
			// 3XXX
			// 30XX -
			// 31XX - CASES
				
			array (
					3100,
					"case",
					"InvalidID",
					"CASES_INVALID_ID",
					""
			),
				
			// CREATE
				
			array (
					3101,
					"category",
					"CodeRequired",
					"CASES_CATEGORY_CODE_REQUIRED",
					""
			),
			array (
					3102,
					"categoryOrType",
					"InvalidCode",
					"CASES_CATEGORY_OR_TYPE_INVALID",
					""
			),
			array (
					3103,
					"caseStatus",
					"InitialStatusNotSelected",
					"CASES_INITIAL_STATUS_NOT_SELECTED",
					""
			),
			array (
					3104,
					"caseResolutionType",
					"InitialResolutionTypeNotSelected",
					"CASES_INITIAL_RESOLUTION_TYPE_NOT_SELECTED",
					""
			),
				
			array (
					3105,
					"execution.categoryOrType",
					"execution.categoryOrType: This field allows letters only. (up to 10 characters)",
					"CASES_CATEGORY_OR_TYPE_ALLOW_LETTERS_ONLY",
					"This field allows letters only. (up to 10 characters)"
			),
				
			// GET CASES
				
			// ADD NOTE
				
			// 32XX - PAY IT FORWARD ACTIVITY
				
			array (
					3202,
					"account",
					"NotEnoughPoints",
					"PAY_IT_FORWARD_NOT_ENOUGH_POINTS",
					""
			),
				
			// GET GIFTS CHAIN (PUBLIC)
				
			// GIFT CLAIMS
				
			array (
					3210,
					"claimCode",
					"ALREADY_CLAIMED",
					"PAY_IT_FORWARD_CODE_ALREADY_CLAIMED",
					""
			),
				
			// GIVE ONE GIFT
				
			// GIVE ONE GIFT (PAYMENT APPROVED)
				
			// 33XX - PAYMENTS USING PAYU
				
			// CREATE PAYMENT
				
			array (
					3301,
					"activity",
					"NotLoggedIn",
					"PAYU_ACTIVITY_NOT_LOGGED_IN",
					""
			),
			array (
					3302,
					"orderRefCode",
					"InvalidCode",
					"PAYU_ORDER_REF_CODE_INVALID",
					""
			),
			array (
					3303,
					"payment",
					"InvalidTransitionState",
					"PAYU_PAYMENT_TRANSACTION_STATE_INVALID",
					""
			),
				
			// UPDATE PAYMENT
				
			// GET PAYMENTS
				
			// 34XX -
				
			// 35XX - REFERENCE DATA
				
			// CUSTOM ITEM LIST
				
			array (
					3500,
					"itemList",
					"InvalidID",
					"REFERENCE_DATA_ITEM_LIST_INVALID_ID",
					""
			),

			// SKU
			array (
					4000,
					"partnerSku",
					"partnerSku.codeAlreadyExists",
					"PARTNER_SKU_ALREADY_EXISTS",
					"Partner Sku Already Exists"
			),
			array (
					4001,
					"execution.partnerSku",
					"execution.partnerSku: The partner SKU code is already used",
					"PARTNER_SKU_ALREADY_EXISTS",
					"Partner Sku Already Exists"
			),
			array (
					4002,
					"partnerSku",
					"partnerSku.name.invalidValue",
					"PARTNER_SKU_NAME_INVALID",
					"The partner SKU name is invalid"
			),
			array (
					4003,
					"execution.partnerSku",
					"execution.partnerSku: The partner SKU name is invalid",
					"PARTNER_SKU_NAME_INVALID",
					"The partner SKU name is invalid"
			),
			array (
					4004,
					"partnerSku",
					"partnerSku.equivalence.invalidValue",
					"PARTNER_SKU_EQUIVALENCE_MUST_BE_GRAETER_THAN_ZERO",
					"The equivalence must be a number greater than zero"
			),
			array (
					4005,
					"execution.partnerSku",
					"execution.partnerSku: The equivalence must be a number greater than zero",
					"PARTNER_SKU_EQUIVALENCE_MUST_BE_GRAETER_THAN_ZERO",
					"The equivalence must be a number greater than zero"
			),
			array (
					4006,
					"partnerEmail",
					"EmailAlreadyExists",
					"PARTNER_EMAIL_ALREADY_EXISTS",
					"Email Already Exists"
			),
			array (
					4007,
					"execution.partnerEmail",
					"execution.partnerEmail: error.EmailAlreadyExists",
					"PARTNER_EMAIL_ALREADY_EXISTS",
					"Email Already Exists"
			),
			array (
					4008,
					"partnerDataSource",
					"InvalidTouchpointCode",
					"DATASOURCE_TOUCHPOINT_INVALID",
					"Invalid Touchpoint Code"
			),
			array (
					4009,
					"execution.partnerDataSource",
					"execution.partnerDataSource: error.InvalidTouchpointCode",
					"PARTNER_EMAIL_ALREADY_EXISTS",
					"Invalid Touchpoint Code"
			),
			array (
					4010,
					"ProcessFile",
					"UnknownFormat",
					"INVALID_FILE_FORMAT",
					"Invalid File Format"
			),
			array (
					4011,
					"execution.ProcessFile",
					"execution.ProcessFile: error.UnknownFormat",
					"INVALID_FILE_FORMAT",
					"Invalid File Format"
			),
			array (
					4012,
					"error.import.header.invalid",
					"Header validation: Column % is invalid.",
					"IMPORT_HEADER_INVALID",
					""
			)
				
	);

	/**
	 * converts camel case string into snake string 
	 * @param String $input
	 * @return string
	 */
	public static function camelToSnake(String $input) {
		return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $input));
	}

	//REQUIRED
	//INVALID_FORMAT
	//INVALID_ID
	//INVALID_VALUE
	//MISMATCH
	public static function getErrorType(String $message) {
		if (strpos($message, 'required') !== false) {
			return 'REQUIRED';
		} else if (strpos($message, 'invalid') !== false and strpos($message, 'value') !== false) {
			return 'INVALID_VALUE';
		} else if (strpos($message, 'mismatch') !== false) {
			return 'MISMATCH';
		} else if (strpos($message, 'invalid') !== false and strpos($message, 'format') !== false) {
			return 'INVALID_FORMAT';
		} else if (strpos($message, 'invalidid') !== false or strpos($message, 'referenceid') !== false) {
			return 'INVALID_ID';
		} else {
			return 'INVALID_FORMAT';
		}
	}

	public static function generateErrorCode(String $code, String $message) {
		//$code
		$arr = array('.', '-', ' ');
		$newCode = str_replace($arr, '_', $code);
		$newCode = self::camelToSnake($newCode);
		$newCode = strtoupper($newCode);

		if (strpos($code, 'person') !== false and strpos($code, 'profile') !== false and strpos($newCode,'PERSON_') == 0) {
			$newCode = str_replace('PERSON_', '', $newCode);
		}

		if (strpos($code, 'company') !== false and strpos($code, 'profile') !== false and strpos($newCode,'COMPANY_') == 0) {
			$newCode = str_replace('COMPANY_', '', $newCode);
		}

		if (strpos($code, 'profile') !== false and strpos($code, 'cellphone') !== false and strpos($newCode,'PROFILE_') == 0) {
			$newCode = str_replace('PROFILE_', '', $newCode);
		}

		if (strpos($code, 'profile') !== false and strpos($code, 'phone') !== false and strpos($newCode,'PROFILE_') == 0) {
			$newCode = str_replace('PROFILE_', '', $newCode);
		}

		if (strpos($code, 'profile') !== false and strpos($code, 'address') !== false and strpos($newCode,'PROFILE_') == 0) {
			$newCode = str_replace('PROFILE_', '', $newCode);
		}

		if (strpos($code, 'consumer.') !== false and strpos($newCode,'CONSUMER_') == 0) {
			$newCode = str_replace('CONSUMER_', 'CONSUMERS_', $newCode);
		}
		
		$message = self::getErrorType(strtolower($message));
		return $newCode . '_' . $message;
	}

	public static function getErrorNameAndDescription(String $codeThalamus, String $messageThalamus) {

		$return = array (
				0,
				self::generateErrorCode($codeThalamus, $messageThalamus),
				"UNKNOWN_CODE_DESCRIPTION"
		);

		//Excepciones
		foreach ( self::$errors as $key => $error ) {
			if ((html_entity_decode(strtolower($error [1])) == html_entity_decode(strtolower($codeThalamus)))){
				if ((html_entity_decode(strtolower($error [2])) == html_entity_decode(strtolower($messageThalamus)))) {
					$return = array (
							$error [0],
							$error [3],
							$error [4]
					);
					continue;
				}else{
					$errorVariables = explode('%',$error [2]);
					$match = true;
					foreach ($errorVariables as $String){
						if (!empty($String) && strpos($messageThalamus, $String)===false){
							$match = false;
						}
					}
					if ($match){
						$return = array (
								$error [0],
								$error [3],
								$error [4]
						);
						continue;
					}
				}
			}
		}

		return $return;
	}

}