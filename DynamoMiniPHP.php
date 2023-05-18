<?php

class DynamoMiniPHP {
    private $endpoint;
    private $region;
    private $accessKey;
    private $secretKey;

    public function __construct($endpoint, $region, $accessKey, $secretKey) {
        $this->endpoint = $endpoint;
        $this->region = $region;
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    public function query($tableName, $keyConditionExpression, $expressionAttributeValues) {
        $url = $this->endpoint;
        $payload = [
            'TableName' => $tableName,
            'KeyConditionExpression' => $keyConditionExpression,
            'ExpressionAttributeValues' => $expressionAttributeValues
        ];

        $headers = [
            'Content-Type: application/x-amz-json-1.0',
            'X-Amz-Target: DynamoDB_20120810.Query',
            'Authorization: ' . $this->generateAuthorizationHeader($url, $payload),
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    private function generateAuthorizationHeader($url, $payload) {
        $method = 'POST';
        $service = 'dynamodb';
        $host = parse_url($url, PHP_URL_HOST);
        $datetime = gmdate('Ymd\THis\Z');
        $date = substr($datetime, 0, 8);

        $canonicalRequest = "{$method}\n/\n\ncontent-type:application/x-amz-json-1.0\nhost:{$host}\nx-amz-date:{$datetime}\n\ncontent-type;host;x-amz-date\n" . hash('sha256', json_encode($payload));

        $credentialScope = "{$date}/{$this->region}/{$service}/aws4_request";
        $stringToSign = "AWS4-HMAC-SHA256\n{$datetime}\n{$credentialScope}\n" . hash('sha256', $canonicalRequest);

        $signingKey = $this->getSigningKey($date);
        $signature = hash_hmac('sha256', $stringToSign, $signingKey);

        $authorizationHeader = "AWS4-HMAC-SHA256 Credential={$this->accessKey}/{$credentialScope}, SignedHeaders=content-type;host;x-amz-date, Signature={$signature}";

        return $authorizationHeader;
    }

    private function getSigningKey($date) {
        $kSecret = 'AWS4' . $this->secretKey;
        $kDate = hash_hmac('sha256', $date, $kSecret, true);
        $kRegion = hash_hmac('sha256', $this->region, $kDate, true);
        $kService = hash_hmac('sha256', 'dynamodb', $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);

        return $kSigning;
    }
}

// Usage example:
$endpoint = 'https://dynamodb.us-east-1.amazonaws.com';
$region = 'us-east-1';
$accessKey = 'YOUR_ACCESS_KEY';
$secretKey = 'YOUR_SECRET_KEY';

$dynamoDB = new DynamoMiniPHP($endpoint, $region, $accessKey, $secretKey);
$tableName = 'YourTableName';
$keyConditionExpression = 'your_key_condition_expression';
$expressionAttributeValues = [
    ':value' => 'your_value'
];

$result = $dynamoDB->query($tableName, $keyConditionExpression, $expressionAttributeValues);
print_r($result);

?>
