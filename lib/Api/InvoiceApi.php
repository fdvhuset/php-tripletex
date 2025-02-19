<?php
/**
 * InvoiceApi
 * PHP version 5
 *
 * @category Class
 * @package  Tripletex
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Tripletex API
 *
 * The Tripletex API is a **RESTful API**, which does not implement PATCH, but uses a PUT with optional fields.  **Actions** or commands are represented in our RESTful path with a prefixed `:`. Example: `/v2/hours/123/:approve`.  **Summaries** or aggregated results are represented in our RESTful path with a prefixed <code>&gt;</code>. Example: <code>/v2/hours/&gt;thisWeeksBillables</code>.  **\"requestID\"** is a key found in all responses in the header with the name `x-tlx-request-id`. For validation and error responses it is also in the response body. If additional log information is absolutely necessary, our support division can locate the key value.  **Download** the [swagger.json](/v2/swagger.json) file [OpenAPI Specification](https://github.com/OAI/OpenAPI-Specification) to [generate code](https://github.com/swagger-api/swagger-codegen). This document was generated from the Swagger JSON file.  **version:** This is a versioning number found on all DB records. If included, it will prevent your PUT/POST from overriding any updates to the record since your GET.  **Date & DateTime** follows the **ISO 8601** standard. Date: `YYYY-MM-DD`. DateTime: `YYYY-MM-DDThh:mm:ssZ`  **Sorting** is done by specifying a comma separated list, where a `-` prefix denotes descending. You can sort by sub object with the following format: `project.name, -date`.  **Searching:** is done by entering values in the optional fields for each API call. The values fall into the following categories: range, in, exact and like.  **Missing fields or even no response data** can occur because result objects and fields are filtered on authorization.  **See [FAQ](https://tripletex.no/execute/docViewer?articleId=906&language=0) for more additional information.**   ## Authentication: - **Tokens:** The Tripletex API uses 3 different tokens - **consumerToken**, **employeeToken** and **sessionToken**.  - **consumerToken** is a token provided to the consumer by Tripletex after the API 2.0 registration is completed.  - **employeeToken** is a token created by an administrator in your Tripletex account via the user settings and the tab \"API access\". Each employee token must be given a set of entitlements. [Read more here.](https://tripletex.no/execute/docViewer?articleId=853&language=0)  - **sessionToken** is the token from `/token/session/:create` which requires a consumerToken and an employeeToken created with the same consumer token, but not an authentication header. See how to create a sessionToken [here](https://tripletex.no/execute/docViewer?articleId=855&language=0). - The session token is used as the password in \"Basic Authentication Header\" for API calls.  - Use blank or `0` as username for accessing the account with regular employee token, or if a company owned employee token accesses <code>/company/&gt;withLoginAccess</code> or <code>/token/session/&gt;whoAmI</code>.  - For company owned employee tokens (accounting offices) the ID from <code>/company/&gt;withLoginAccess</code> can be used as username for accessing client accounts.  - If you need to create the header yourself use <code>Authorization: Basic &lt;base64encode('0:sessionToken')&gt;</code>.   ## Tags: - **[BETA]** This is a beta endpoint and can be subject to change. - **[DEPRECATED]** Deprecated means that we intend to remove/change this feature or capability in a future \"major\" API release. We therefore discourage all use of this feature/capability.  ## Fields: Use the `fields` parameter to specify which fields should be returned. This also supports fields from sub elements. Example values: - `project,activity,hours`  returns `{project:..., activity:...., hours:...}`. - just `project` returns `\"project\" : { \"id\": 12345, \"url\": \"tripletex.no/v2/projects/12345\"  }`. - `project(*)` returns `\"project\" : { \"id\": 12345 \"name\":\"ProjectName\" \"number.....startDate\": \"2013-01-07\" }`. - `project(name)` returns `\"project\" : { \"name\":\"ProjectName\" }`. - All elements and some subElements :  `*,activity(name),employee(*)`.  ## Changes: To get the changes for a resource, `changes` have to be explicitly specified as part of the `fields` parameter, e.g. `*,changes`. There are currently two types of change available:  - `CREATE` for when the resource was created - `UPDATE` for when the resource was updated  NOTE: For objects created prior to October 24th 2018 the list may be incomplete, but will always contain the CREATE and the last change (if the object has been changed after creation).  ## Rate limiting in each response header: Rate limiting is performed on the API calls for an employee for each API consumer. Status regarding the rate limit is returned as headers: - `X-Rate-Limit-Limit` - The number of allowed requests in the current period. - `X-Rate-Limit-Remaining` - The number of remaining requests. - `X-Rate-Limit-Reset` - The number of seconds left in the current period.  Once the rate limit is hit, all requests will return HTTP status code `429` for the remainder of the current period.   ## Response envelope: ```json {   \"fullResultSize\": ###,   \"from\": ###, // Paging starting from   \"count\": ###, // Paging count   \"versionDigest\": \"Hash of full result\",   \"values\": [...list of objects...] } {   \"value\": {...single object...} } ```   ## WebHook envelope: ```json {   \"subscriptionId\": ###,   \"event\": \"object.verb\", // As listed from /v2/event/   \"id\": ###, // Object id   \"value\": {... single object, null if object.deleted ...} } ```    ## Error/warning envelope: ```json {   \"status\": ###, // HTTP status code   \"code\": #####, // internal status code of event   \"message\": \"Basic feedback message in your language\",   \"link\": \"Link to doc\",   \"developerMessage\": \"More technical message\",   \"validationMessages\": [ // Will be null if Error     {       \"field\": \"Name of field\",       \"message\": \"Validation failure information\"     }   ],   \"requestId\": \"UUID used in any logs\" } ```   ## Status codes / Error codes: - **200 OK** - **201 Created** - From POSTs that create something new. - **204 No Content** - When there is no answer, ex: \"/:anAction\" or DELETE. - **400 Bad request** -   - **4000** Bad Request Exception   - **11000** Illegal Filter Exception   - **12000** Path Param Exception   - **24000**   Cryptography Exception - **401 Unauthorized** - When authentication is required and has failed or has not yet been provided   -  **3000** Authentication Exception - **403 Forbidden** - When AuthorisationManager says no.   -  **9000** Security Exception - **404 Not Found** - For content/IDs that does not exist.   -  **6000** Not Found Exception - **409 Conflict** - Such as an edit conflict between multiple simultaneous updates   -  **7000** Object Exists Exception   -  **8000** Revision Exception   - **10000** Locked Exception   - **14000** Duplicate entry - **422 Bad Request** - For Required fields or things like malformed payload.   - **15000** Value Validation Exception   - **16000** Mapping Exception   - **17000** Sorting Exception   - **18000** Validation Exception   - **21000** Param Exception   - **22000** Invalid JSON Exception   - **23000**   Result Set Too Large Exception - **429 Too Many Requests** - Request rate limit hit - **500 Internal Error** -  Unexpected condition was encountered and no more specific message is suitable   -  **1000** Exception
 *
 * OpenAPI spec version: 2.38.5
 *
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.16
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Tripletex\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Tripletex\ApiException;
use Tripletex\Configuration;
use Tripletex\HeaderSelector;
use Tripletex\ObjectSerializer;

/**
 * InvoiceApi Class Doc Comment
 *
 * @category Class
 * @package  Tripletex
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class InvoiceApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation createCreditNote
     *
     * Creates a new Invoice representing a credit memo that nullifies the given invoice. Updates this invoice and any pre-existing inverse invoice.
     *
     * @param  int $id Invoice id (required)
     * @param  string $date Credit note date (required)
     * @param  string $comment Comment (optional)
     * @param  string $credit_note_email The credit note will be sent electronically if this field is filled out (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Tripletex\Model\ResponseWrapperInvoice
     */
    public function createCreditNote($id, $date, $comment = null, $credit_note_email = null)
    {
        list($response) = $this->createCreditNoteWithHttpInfo($id, $date, $comment, $credit_note_email);
        return $response;
    }

    /**
     * Operation createCreditNoteWithHttpInfo
     *
     * Creates a new Invoice representing a credit memo that nullifies the given invoice. Updates this invoice and any pre-existing inverse invoice.
     *
     * @param  int $id Invoice id (required)
     * @param  string $date Credit note date (required)
     * @param  string $comment Comment (optional)
     * @param  string $credit_note_email The credit note will be sent electronically if this field is filled out (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Tripletex\Model\ResponseWrapperInvoice, HTTP status code, HTTP response headers (array of strings)
     */
    public function createCreditNoteWithHttpInfo($id, $date, $comment = null, $credit_note_email = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->createCreditNoteRequest($id, $date, $comment, $credit_note_email);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Tripletex\Model\ResponseWrapperInvoice',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation createCreditNoteAsync
     *
     * Creates a new Invoice representing a credit memo that nullifies the given invoice. Updates this invoice and any pre-existing inverse invoice.
     *
     * @param  int $id Invoice id (required)
     * @param  string $date Credit note date (required)
     * @param  string $comment Comment (optional)
     * @param  string $credit_note_email The credit note will be sent electronically if this field is filled out (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createCreditNoteAsync($id, $date, $comment = null, $credit_note_email = null)
    {
        return $this->createCreditNoteAsyncWithHttpInfo($id, $date, $comment, $credit_note_email)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation createCreditNoteAsyncWithHttpInfo
     *
     * Creates a new Invoice representing a credit memo that nullifies the given invoice. Updates this invoice and any pre-existing inverse invoice.
     *
     * @param  int $id Invoice id (required)
     * @param  string $date Credit note date (required)
     * @param  string $comment Comment (optional)
     * @param  string $credit_note_email The credit note will be sent electronically if this field is filled out (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createCreditNoteAsyncWithHttpInfo($id, $date, $comment = null, $credit_note_email = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->createCreditNoteRequest($id, $date, $comment, $credit_note_email);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'createCreditNote'
     *
     * @param  int $id Invoice id (required)
     * @param  string $date Credit note date (required)
     * @param  string $comment Comment (optional)
     * @param  string $credit_note_email The credit note will be sent electronically if this field is filled out (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function createCreditNoteRequest($id, $date, $comment = null, $credit_note_email = null)
    {
        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling createCreditNote'
            );
        }
        // verify the required parameter 'date' is set
        if ($date === null || (is_array($date) && count($date) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $date when calling createCreditNote'
            );
        }

        $resourcePath = '/invoice/{id}/:createCreditNote';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($date !== null) {
            $queryParams['date'] = ObjectSerializer::toQueryValue($date);
        }
        // query params
        if ($comment !== null) {
            $queryParams['comment'] = ObjectSerializer::toQueryValue($comment);
        }
        // query params
        if ($credit_note_email !== null) {
            $queryParams['creditNoteEmail'] = ObjectSerializer::toQueryValue($credit_note_email);
        }

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'PUT',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation createReminder
     *
     * Create invoice reminder and sends it by the given dispatch type. Supports the reminder types SOFT_REMINDER, REMINDER and NOTICE_OF_DEBT_COLLECTION. DispatchType NETS_PRINT must have type NOTICE_OF_DEBT_COLLECTION. SMS and NETS_PRINT must be activated prior to usage in the API.
     *
     * @param  int $id Element ID (required)
     * @param  string $type type (required)
     * @param  string $date yyyy-MM-dd. Defaults to today. (required)
     * @param  string $dispatch_type dispatchType (required)
     * @param  bool $include_charge Equals (optional)
     * @param  bool $include_interest Equals (optional)
     * @param  string $sms_number SMS number (must be a valid Norwegian telephone number) (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function createReminder($id, $type, $date, $dispatch_type, $include_charge = null, $include_interest = null, $sms_number = null)
    {
        $this->createReminderWithHttpInfo($id, $type, $date, $dispatch_type, $include_charge, $include_interest, $sms_number);
    }

    /**
     * Operation createReminderWithHttpInfo
     *
     * Create invoice reminder and sends it by the given dispatch type. Supports the reminder types SOFT_REMINDER, REMINDER and NOTICE_OF_DEBT_COLLECTION. DispatchType NETS_PRINT must have type NOTICE_OF_DEBT_COLLECTION. SMS and NETS_PRINT must be activated prior to usage in the API.
     *
     * @param  int $id Element ID (required)
     * @param  string $type type (required)
     * @param  string $date yyyy-MM-dd. Defaults to today. (required)
     * @param  string $dispatch_type dispatchType (required)
     * @param  bool $include_charge Equals (optional)
     * @param  bool $include_interest Equals (optional)
     * @param  string $sms_number SMS number (must be a valid Norwegian telephone number) (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function createReminderWithHttpInfo($id, $type, $date, $dispatch_type, $include_charge = null, $include_interest = null, $sms_number = null)
    {
        $returnType = '';
        $request = $this->createReminderRequest($id, $type, $date, $dispatch_type, $include_charge, $include_interest, $sms_number);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation createReminderAsync
     *
     * Create invoice reminder and sends it by the given dispatch type. Supports the reminder types SOFT_REMINDER, REMINDER and NOTICE_OF_DEBT_COLLECTION. DispatchType NETS_PRINT must have type NOTICE_OF_DEBT_COLLECTION. SMS and NETS_PRINT must be activated prior to usage in the API.
     *
     * @param  int $id Element ID (required)
     * @param  string $type type (required)
     * @param  string $date yyyy-MM-dd. Defaults to today. (required)
     * @param  string $dispatch_type dispatchType (required)
     * @param  bool $include_charge Equals (optional)
     * @param  bool $include_interest Equals (optional)
     * @param  string $sms_number SMS number (must be a valid Norwegian telephone number) (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createReminderAsync($id, $type, $date, $dispatch_type, $include_charge = null, $include_interest = null, $sms_number = null)
    {
        return $this->createReminderAsyncWithHttpInfo($id, $type, $date, $dispatch_type, $include_charge, $include_interest, $sms_number)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation createReminderAsyncWithHttpInfo
     *
     * Create invoice reminder and sends it by the given dispatch type. Supports the reminder types SOFT_REMINDER, REMINDER and NOTICE_OF_DEBT_COLLECTION. DispatchType NETS_PRINT must have type NOTICE_OF_DEBT_COLLECTION. SMS and NETS_PRINT must be activated prior to usage in the API.
     *
     * @param  int $id Element ID (required)
     * @param  string $type type (required)
     * @param  string $date yyyy-MM-dd. Defaults to today. (required)
     * @param  string $dispatch_type dispatchType (required)
     * @param  bool $include_charge Equals (optional)
     * @param  bool $include_interest Equals (optional)
     * @param  string $sms_number SMS number (must be a valid Norwegian telephone number) (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function createReminderAsyncWithHttpInfo($id, $type, $date, $dispatch_type, $include_charge = null, $include_interest = null, $sms_number = null)
    {
        $returnType = '';
        $request = $this->createReminderRequest($id, $type, $date, $dispatch_type, $include_charge, $include_interest, $sms_number);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'createReminder'
     *
     * @param  int $id Element ID (required)
     * @param  string $type type (required)
     * @param  string $date yyyy-MM-dd. Defaults to today. (required)
     * @param  string $dispatch_type dispatchType (required)
     * @param  bool $include_charge Equals (optional)
     * @param  bool $include_interest Equals (optional)
     * @param  string $sms_number SMS number (must be a valid Norwegian telephone number) (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function createReminderRequest($id, $type, $date, $dispatch_type, $include_charge = null, $include_interest = null, $sms_number = null)
    {
        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling createReminder'
            );
        }
        // verify the required parameter 'type' is set
        if ($type === null || (is_array($type) && count($type) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $type when calling createReminder'
            );
        }
        // verify the required parameter 'date' is set
        if ($date === null || (is_array($date) && count($date) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $date when calling createReminder'
            );
        }
        // verify the required parameter 'dispatch_type' is set
        if ($dispatch_type === null || (is_array($dispatch_type) && count($dispatch_type) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $dispatch_type when calling createReminder'
            );
        }

        $resourcePath = '/invoice/{id}/:createReminder';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($type !== null) {
            $queryParams['type'] = ObjectSerializer::toQueryValue($type);
        }
        // query params
        if ($date !== null) {
            $queryParams['date'] = ObjectSerializer::toQueryValue($date);
        }
        // query params
        if ($include_charge !== null) {
            $queryParams['includeCharge'] = ObjectSerializer::toQueryValue($include_charge);
        }
        // query params
        if ($include_interest !== null) {
            $queryParams['includeInterest'] = ObjectSerializer::toQueryValue($include_interest);
        }
        // query params
        if ($dispatch_type !== null) {
            $queryParams['dispatchType'] = ObjectSerializer::toQueryValue($dispatch_type);
        }
        // query params
        if ($sms_number !== null) {
            $queryParams['smsNumber'] = ObjectSerializer::toQueryValue($sms_number);
        }

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'PUT',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation downloadPdf
     *
     * Get invoice document by invoice ID.
     *
     * @param  int $invoice_id Invoice ID from which PDF is downloaded. (required)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return string
     */
    public function downloadPdf($invoice_id)
    {
        list($response) = $this->downloadPdfWithHttpInfo($invoice_id);
        return $response;
    }

    /**
     * Operation downloadPdfWithHttpInfo
     *
     * Get invoice document by invoice ID.
     *
     * @param  int $invoice_id Invoice ID from which PDF is downloaded. (required)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of string, HTTP status code, HTTP response headers (array of strings)
     */
    public function downloadPdfWithHttpInfo($invoice_id)
    {
        $returnType = 'string';
        $request = $this->downloadPdfRequest($invoice_id);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        'string',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation downloadPdfAsync
     *
     * Get invoice document by invoice ID.
     *
     * @param  int $invoice_id Invoice ID from which PDF is downloaded. (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function downloadPdfAsync($invoice_id)
    {
        return $this->downloadPdfAsyncWithHttpInfo($invoice_id)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation downloadPdfAsyncWithHttpInfo
     *
     * Get invoice document by invoice ID.
     *
     * @param  int $invoice_id Invoice ID from which PDF is downloaded. (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function downloadPdfAsyncWithHttpInfo($invoice_id)
    {
        $returnType = 'string';
        $request = $this->downloadPdfRequest($invoice_id);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'downloadPdf'
     *
     * @param  int $invoice_id Invoice ID from which PDF is downloaded. (required)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function downloadPdfRequest($invoice_id)
    {
        // verify the required parameter 'invoice_id' is set
        if ($invoice_id === null || (is_array($invoice_id) && count($invoice_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $invoice_id when calling downloadPdf'
            );
        }

        $resourcePath = '/invoice/{invoiceId}/pdf';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // path params
        if ($invoice_id !== null) {
            $resourcePath = str_replace(
                '{' . 'invoiceId' . '}',
                ObjectSerializer::toPathValue($invoice_id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/octet-stream']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/octet-stream'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation get
     *
     * Get invoice by ID.
     *
     * @param  int $id Element ID (required)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Tripletex\Model\ResponseWrapperInvoice
     */
    public function get($id, $fields = null)
    {
        list($response) = $this->getWithHttpInfo($id, $fields);
        return $response;
    }

    /**
     * Operation getWithHttpInfo
     *
     * Get invoice by ID.
     *
     * @param  int $id Element ID (required)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Tripletex\Model\ResponseWrapperInvoice, HTTP status code, HTTP response headers (array of strings)
     */
    public function getWithHttpInfo($id, $fields = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->getRequest($id, $fields);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Tripletex\Model\ResponseWrapperInvoice',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getAsync
     *
     * Get invoice by ID.
     *
     * @param  int $id Element ID (required)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getAsync($id, $fields = null)
    {
        return $this->getAsyncWithHttpInfo($id, $fields)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getAsyncWithHttpInfo
     *
     * Get invoice by ID.
     *
     * @param  int $id Element ID (required)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getAsyncWithHttpInfo($id, $fields = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->getRequest($id, $fields);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'get'
     *
     * @param  int $id Element ID (required)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getRequest($id, $fields = null)
    {
        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling get'
            );
        }

        $resourcePath = '/invoice/{id}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($fields !== null) {
            $queryParams['fields'] = ObjectSerializer::toQueryValue($fields);
        }

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation payment
     *
     * Update invoice. The invoice is updated with payment information. The amount is in the invoice’s currency.
     *
     * @param  int $id Invoice id (required)
     * @param  string $payment_date Payment date (required)
     * @param  int $payment_type_id PaymentType id (required)
     * @param  float $paid_amount Amount paid by customer in the company currency, typically NOK. (required)
     * @param  float $paid_amount_currency Amount paid by customer in the invoice currency. Optional, but required for invoices in alternate currencies. (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Tripletex\Model\ResponseWrapperInvoice
     */
    public function payment($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency = null)
    {
        list($response) = $this->paymentWithHttpInfo($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency);
        return $response;
    }

    /**
     * Operation paymentWithHttpInfo
     *
     * Update invoice. The invoice is updated with payment information. The amount is in the invoice’s currency.
     *
     * @param  int $id Invoice id (required)
     * @param  string $payment_date Payment date (required)
     * @param  int $payment_type_id PaymentType id (required)
     * @param  float $paid_amount Amount paid by customer in the company currency, typically NOK. (required)
     * @param  float $paid_amount_currency Amount paid by customer in the invoice currency. Optional, but required for invoices in alternate currencies. (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Tripletex\Model\ResponseWrapperInvoice, HTTP status code, HTTP response headers (array of strings)
     */
    public function paymentWithHttpInfo($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->paymentRequest($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Tripletex\Model\ResponseWrapperInvoice',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation paymentAsync
     *
     * Update invoice. The invoice is updated with payment information. The amount is in the invoice’s currency.
     *
     * @param  int $id Invoice id (required)
     * @param  string $payment_date Payment date (required)
     * @param  int $payment_type_id PaymentType id (required)
     * @param  float $paid_amount Amount paid by customer in the company currency, typically NOK. (required)
     * @param  float $paid_amount_currency Amount paid by customer in the invoice currency. Optional, but required for invoices in alternate currencies. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function paymentAsync($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency = null)
    {
        return $this->paymentAsyncWithHttpInfo($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation paymentAsyncWithHttpInfo
     *
     * Update invoice. The invoice is updated with payment information. The amount is in the invoice’s currency.
     *
     * @param  int $id Invoice id (required)
     * @param  string $payment_date Payment date (required)
     * @param  int $payment_type_id PaymentType id (required)
     * @param  float $paid_amount Amount paid by customer in the company currency, typically NOK. (required)
     * @param  float $paid_amount_currency Amount paid by customer in the invoice currency. Optional, but required for invoices in alternate currencies. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function paymentAsyncWithHttpInfo($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->paymentRequest($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'payment'
     *
     * @param  int $id Invoice id (required)
     * @param  string $payment_date Payment date (required)
     * @param  int $payment_type_id PaymentType id (required)
     * @param  float $paid_amount Amount paid by customer in the company currency, typically NOK. (required)
     * @param  float $paid_amount_currency Amount paid by customer in the invoice currency. Optional, but required for invoices in alternate currencies. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function paymentRequest($id, $payment_date, $payment_type_id, $paid_amount, $paid_amount_currency = null)
    {
        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling payment'
            );
        }
        // verify the required parameter 'payment_date' is set
        if ($payment_date === null || (is_array($payment_date) && count($payment_date) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $payment_date when calling payment'
            );
        }
        // verify the required parameter 'payment_type_id' is set
        if ($payment_type_id === null || (is_array($payment_type_id) && count($payment_type_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $payment_type_id when calling payment'
            );
        }
        // verify the required parameter 'paid_amount' is set
        if ($paid_amount === null || (is_array($paid_amount) && count($paid_amount) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $paid_amount when calling payment'
            );
        }

        $resourcePath = '/invoice/{id}/:payment';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($payment_date !== null) {
            $queryParams['paymentDate'] = ObjectSerializer::toQueryValue($payment_date);
        }
        // query params
        if ($payment_type_id !== null) {
            $queryParams['paymentTypeId'] = ObjectSerializer::toQueryValue($payment_type_id);
        }
        // query params
        if ($paid_amount !== null) {
            $queryParams['paidAmount'] = ObjectSerializer::toQueryValue($paid_amount);
        }
        // query params
        if ($paid_amount_currency !== null) {
            $queryParams['paidAmountCurrency'] = ObjectSerializer::toQueryValue($paid_amount_currency);
        }

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'PUT',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation post
     *
     * Create invoice.
     *
     * @param  \Tripletex\Model\Invoice $body JSON representing the new object to be created. Should not have ID and version set. (optional)
     * @param  bool $send_to_customer Equals (optional)
     * @param  int $payment_type_id Payment type to register prepayment of the invoice. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     * @param  float $paid_amount Paid amount to register prepayment of the invoice, in invoice currency. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Tripletex\Model\ResponseWrapperInvoice
     */
    public function post($body = null, $send_to_customer = null, $payment_type_id = null, $paid_amount = null)
    {
        list($response) = $this->postWithHttpInfo($body, $send_to_customer, $payment_type_id, $paid_amount);
        return $response;
    }

    /**
     * Operation postWithHttpInfo
     *
     * Create invoice.
     *
     * @param  \Tripletex\Model\Invoice $body JSON representing the new object to be created. Should not have ID and version set. (optional)
     * @param  bool $send_to_customer Equals (optional)
     * @param  int $payment_type_id Payment type to register prepayment of the invoice. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     * @param  float $paid_amount Paid amount to register prepayment of the invoice, in invoice currency. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Tripletex\Model\ResponseWrapperInvoice, HTTP status code, HTTP response headers (array of strings)
     */
    public function postWithHttpInfo($body = null, $send_to_customer = null, $payment_type_id = null, $paid_amount = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->postRequest($body, $send_to_customer, $payment_type_id, $paid_amount);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Tripletex\Model\ResponseWrapperInvoice',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation postAsync
     *
     * Create invoice.
     *
     * @param  \Tripletex\Model\Invoice $body JSON representing the new object to be created. Should not have ID and version set. (optional)
     * @param  bool $send_to_customer Equals (optional)
     * @param  int $payment_type_id Payment type to register prepayment of the invoice. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     * @param  float $paid_amount Paid amount to register prepayment of the invoice, in invoice currency. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function postAsync($body = null, $send_to_customer = null, $payment_type_id = null, $paid_amount = null)
    {
        return $this->postAsyncWithHttpInfo($body, $send_to_customer, $payment_type_id, $paid_amount)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation postAsyncWithHttpInfo
     *
     * Create invoice.
     *
     * @param  \Tripletex\Model\Invoice $body JSON representing the new object to be created. Should not have ID and version set. (optional)
     * @param  bool $send_to_customer Equals (optional)
     * @param  int $payment_type_id Payment type to register prepayment of the invoice. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     * @param  float $paid_amount Paid amount to register prepayment of the invoice, in invoice currency. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function postAsyncWithHttpInfo($body = null, $send_to_customer = null, $payment_type_id = null, $paid_amount = null)
    {
        $returnType = '\Tripletex\Model\ResponseWrapperInvoice';
        $request = $this->postRequest($body, $send_to_customer, $payment_type_id, $paid_amount);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'post'
     *
     * @param  \Tripletex\Model\Invoice $body JSON representing the new object to be created. Should not have ID and version set. (optional)
     * @param  bool $send_to_customer Equals (optional)
     * @param  int $payment_type_id Payment type to register prepayment of the invoice. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     * @param  float $paid_amount Paid amount to register prepayment of the invoice, in invoice currency. paymentTypeId and paidAmount are optional, but both must be provided if the invoice has already been paid. (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function postRequest($body = null, $send_to_customer = null, $payment_type_id = null, $paid_amount = null)
    {

        $resourcePath = '/invoice';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($send_to_customer !== null) {
            $queryParams['sendToCustomer'] = ObjectSerializer::toQueryValue($send_to_customer);
        }
        // query params
        if ($payment_type_id !== null) {
            $queryParams['paymentTypeId'] = ObjectSerializer::toQueryValue($payment_type_id);
        }
        // query params
        if ($paid_amount !== null) {
            $queryParams['paidAmount'] = ObjectSerializer::toQueryValue($paid_amount);
        }


        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                ['application/json; charset=utf-8']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation search
     *
     * Find invoices corresponding with sent data. Includes charged outgoing invoices only.
     *
     * @param  string $invoice_date_from From and including (required)
     * @param  string $invoice_date_to To and excluding (required)
     * @param  string $id List of IDs (optional)
     * @param  string $invoice_number Equals (optional)
     * @param  string $kid Equals (optional)
     * @param  string $voucher_id Equals (optional)
     * @param  string $customer_id Equals (optional)
     * @param  int $from From index (optional)
     * @param  int $count Number of elements to return (optional)
     * @param  string $sorting Sorting pattern (optional)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Tripletex\Model\ListResponseInvoice
     */
    public function search($invoice_date_from, $invoice_date_to, $id = null, $invoice_number = null, $kid = null, $voucher_id = null, $customer_id = null, $from = null, $count = null, $sorting = null, $fields = null)
    {
        list($response) = $this->searchWithHttpInfo($invoice_date_from, $invoice_date_to, $id, $invoice_number, $kid, $voucher_id, $customer_id, $from, $count, $sorting, $fields);
        return $response;
    }

    /**
     * Operation searchWithHttpInfo
     *
     * Find invoices corresponding with sent data. Includes charged outgoing invoices only.
     *
     * @param  string $invoice_date_from From and including (required)
     * @param  string $invoice_date_to To and excluding (required)
     * @param  string $id List of IDs (optional)
     * @param  string $invoice_number Equals (optional)
     * @param  string $kid Equals (optional)
     * @param  string $voucher_id Equals (optional)
     * @param  string $customer_id Equals (optional)
     * @param  int $from From index (optional)
     * @param  int $count Number of elements to return (optional)
     * @param  string $sorting Sorting pattern (optional)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Tripletex\Model\ListResponseInvoice, HTTP status code, HTTP response headers (array of strings)
     */
    public function searchWithHttpInfo($invoice_date_from, $invoice_date_to, $id = null, $invoice_number = null, $kid = null, $voucher_id = null, $customer_id = null, $from = null, $count = null, $sorting = null, $fields = null)
    {
        $returnType = '\Tripletex\Model\ListResponseInvoice';
        $request = $this->searchRequest($invoice_date_from, $invoice_date_to, $id, $invoice_number, $kid, $voucher_id, $customer_id, $from, $count, $sorting, $fields);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Tripletex\Model\ListResponseInvoice',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation searchAsync
     *
     * Find invoices corresponding with sent data. Includes charged outgoing invoices only.
     *
     * @param  string $invoice_date_from From and including (required)
     * @param  string $invoice_date_to To and excluding (required)
     * @param  string $id List of IDs (optional)
     * @param  string $invoice_number Equals (optional)
     * @param  string $kid Equals (optional)
     * @param  string $voucher_id Equals (optional)
     * @param  string $customer_id Equals (optional)
     * @param  int $from From index (optional)
     * @param  int $count Number of elements to return (optional)
     * @param  string $sorting Sorting pattern (optional)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function searchAsync($invoice_date_from, $invoice_date_to, $id = null, $invoice_number = null, $kid = null, $voucher_id = null, $customer_id = null, $from = null, $count = null, $sorting = null, $fields = null)
    {
        return $this->searchAsyncWithHttpInfo($invoice_date_from, $invoice_date_to, $id, $invoice_number, $kid, $voucher_id, $customer_id, $from, $count, $sorting, $fields)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation searchAsyncWithHttpInfo
     *
     * Find invoices corresponding with sent data. Includes charged outgoing invoices only.
     *
     * @param  string $invoice_date_from From and including (required)
     * @param  string $invoice_date_to To and excluding (required)
     * @param  string $id List of IDs (optional)
     * @param  string $invoice_number Equals (optional)
     * @param  string $kid Equals (optional)
     * @param  string $voucher_id Equals (optional)
     * @param  string $customer_id Equals (optional)
     * @param  int $from From index (optional)
     * @param  int $count Number of elements to return (optional)
     * @param  string $sorting Sorting pattern (optional)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function searchAsyncWithHttpInfo($invoice_date_from, $invoice_date_to, $id = null, $invoice_number = null, $kid = null, $voucher_id = null, $customer_id = null, $from = null, $count = null, $sorting = null, $fields = null)
    {
        $returnType = '\Tripletex\Model\ListResponseInvoice';
        $request = $this->searchRequest($invoice_date_from, $invoice_date_to, $id, $invoice_number, $kid, $voucher_id, $customer_id, $from, $count, $sorting, $fields);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'search'
     *
     * @param  string $invoice_date_from From and including (required)
     * @param  string $invoice_date_to To and excluding (required)
     * @param  string $id List of IDs (optional)
     * @param  string $invoice_number Equals (optional)
     * @param  string $kid Equals (optional)
     * @param  string $voucher_id Equals (optional)
     * @param  string $customer_id Equals (optional)
     * @param  int $from From index (optional)
     * @param  int $count Number of elements to return (optional)
     * @param  string $sorting Sorting pattern (optional)
     * @param  string $fields Fields filter pattern (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function searchRequest($invoice_date_from, $invoice_date_to, $id = null, $invoice_number = null, $kid = null, $voucher_id = null, $customer_id = null, $from = null, $count = null, $sorting = null, $fields = null)
    {
        // verify the required parameter 'invoice_date_from' is set
        if ($invoice_date_from === null || (is_array($invoice_date_from) && count($invoice_date_from) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $invoice_date_from when calling search'
            );
        }
        // verify the required parameter 'invoice_date_to' is set
        if ($invoice_date_to === null || (is_array($invoice_date_to) && count($invoice_date_to) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $invoice_date_to when calling search'
            );
        }

        $resourcePath = '/invoice';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($id !== null) {
            $queryParams['id'] = ObjectSerializer::toQueryValue($id);
        }
        // query params
        if ($invoice_date_from !== null) {
            $queryParams['invoiceDateFrom'] = ObjectSerializer::toQueryValue($invoice_date_from);
        }
        // query params
        if ($invoice_date_to !== null) {
            $queryParams['invoiceDateTo'] = ObjectSerializer::toQueryValue($invoice_date_to);
        }
        // query params
        if ($invoice_number !== null) {
            $queryParams['invoiceNumber'] = ObjectSerializer::toQueryValue($invoice_number);
        }
        // query params
        if ($kid !== null) {
            $queryParams['kid'] = ObjectSerializer::toQueryValue($kid);
        }
        // query params
        if ($voucher_id !== null) {
            $queryParams['voucherId'] = ObjectSerializer::toQueryValue($voucher_id);
        }
        // query params
        if ($customer_id !== null) {
            $queryParams['customerId'] = ObjectSerializer::toQueryValue($customer_id);
        }
        // query params
        if ($from !== null) {
            $queryParams['from'] = ObjectSerializer::toQueryValue($from);
        }
        // query params
        if ($count !== null) {
            $queryParams['count'] = ObjectSerializer::toQueryValue($count);
        }
        // query params
        if ($sorting !== null) {
            $queryParams['sorting'] = ObjectSerializer::toQueryValue($sorting);
        }
        // query params
        if ($fields !== null) {
            $queryParams['fields'] = ObjectSerializer::toQueryValue($fields);
        }


        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation send
     *
     * Send invoice by ID and sendType. Optionally override email recipient.
     *
     * @param  int $id Element ID (required)
     * @param  string $send_type SendType (required)
     * @param  string $override_email_address Will override email address if sendType &#x3D; EMAIL (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return void
     */
    public function send($id, $send_type, $override_email_address = null)
    {
        $this->sendWithHttpInfo($id, $send_type, $override_email_address);
    }

    /**
     * Operation sendWithHttpInfo
     *
     * Send invoice by ID and sendType. Optionally override email recipient.
     *
     * @param  int $id Element ID (required)
     * @param  string $send_type SendType (required)
     * @param  string $override_email_address Will override email address if sendType &#x3D; EMAIL (optional)
     *
     * @throws \Tripletex\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function sendWithHttpInfo($id, $send_type, $override_email_address = null)
    {
        $returnType = '';
        $request = $this->sendRequest($id, $send_type, $override_email_address);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            return [null, $statusCode, $response->getHeaders()];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation sendAsync
     *
     * Send invoice by ID and sendType. Optionally override email recipient.
     *
     * @param  int $id Element ID (required)
     * @param  string $send_type SendType (required)
     * @param  string $override_email_address Will override email address if sendType &#x3D; EMAIL (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendAsync($id, $send_type, $override_email_address = null)
    {
        return $this->sendAsyncWithHttpInfo($id, $send_type, $override_email_address)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation sendAsyncWithHttpInfo
     *
     * Send invoice by ID and sendType. Optionally override email recipient.
     *
     * @param  int $id Element ID (required)
     * @param  string $send_type SendType (required)
     * @param  string $override_email_address Will override email address if sendType &#x3D; EMAIL (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendAsyncWithHttpInfo($id, $send_type, $override_email_address = null)
    {
        $returnType = '';
        $request = $this->sendRequest($id, $send_type, $override_email_address);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'send'
     *
     * @param  int $id Element ID (required)
     * @param  string $send_type SendType (required)
     * @param  string $override_email_address Will override email address if sendType &#x3D; EMAIL (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function sendRequest($id, $send_type, $override_email_address = null)
    {
        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling send'
            );
        }
        // verify the required parameter 'send_type' is set
        if ($send_type === null || (is_array($send_type) && count($send_type) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $send_type when calling send'
            );
        }

        $resourcePath = '/invoice/{id}/:send';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($send_type !== null) {
            $queryParams['sendType'] = ObjectSerializer::toQueryValue($send_type);
        }
        // query params
        if ($override_email_address !== null) {
            $queryParams['overrideEmailAddress'] = ObjectSerializer::toQueryValue($override_email_address);
        }

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if ($this->config->getUsername() !== null || $this->config->getPassword() !== null) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'PUT',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
