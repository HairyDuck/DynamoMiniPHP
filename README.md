[![StyleCI](https://github.styleci.io/repos/642356696/shield?branch=main)](https://github.styleci.io/repos/642356696?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/hairyduck/dynamominiphp/badge)](https://www.codefactor.io/repository/github/hairyduck/dynamominiphp)
[![GitHub issues](https://img.shields.io/github/issues/hairyduck/dynamominiphp)](https://github.com/HairyDuck/DynamoMiniPHP/issues)
[![GitHub forks](https://img.shields.io/github/forks/hairyduck/dynamominiphp)](https://github.com/HairyDuck/DynamoMiniPHP/network/members)
[![GitHub stars](https://img.shields.io/github/stars/hairyduck/dynamominiphp)](https://github.com/HairyDuck/DynamoMiniPHP/stargazers)
[![GitHub license](https://img.shields.io/github/license/hairyduck/dynamominiphp)](https://github.com/HairyDuck/DynamoMiniPHP/blob/main/LICENSE)


# DynamoMiniPHP

DynamoMiniPHP is a lightweight and fast PHP wrapper for AWS DynamoDB. It provides a simplified interface to interact with DynamoDB without the need for additional dependencies or the AWS SDK. It is designed to be easy to learn, use, and modify for your DynamoDB needs.

## Features

- Small and fast: The wrapper is designed to be lightweight and performant, allowing for efficient interactions with DynamoDB.
- Stand-alone: It doesn't require the AWS SDK or other external libraries, making it easy to integrate into your PHP projects.
- Simple interface: The wrapper offers a simplified interface for common DynamoDB operations.

## Installation

1. Clone the repository:

```
git clone https://github.com/HairyDuck/DynamoMiniPHP.git
```

2. Include the `DynamoMiniPHP.php` file in your PHP project:

```php
require_once 'path/to/DynamoMiniPHP/DynamoMiniPHP.php';
```

## Usage

To use DynamoMiniPHP, follow these steps:

1. Create an instance of the `DynamoMiniPHP` class, providing the necessary AWS credentials and endpoint:

```php
$endpoint = 'https://dynamodb.us-east-1.amazonaws.com';
$region = 'us-east-1';
$accessKey = 'YOUR_ACCESS_KEY';
$secretKey = 'YOUR_SECRET_KEY';

$dynamoDB = new DynamoMiniPHP($endpoint, $region, $accessKey, $secretKey);
```

2. Call the desired DynamoDB operation using the provided methods. For example, to perform a query:

```php
$tableName = 'YourTableName';
$keyConditionExpression = 'your_key_condition_expression';
$expressionAttributeValues = [
    ':value' => 'your_value'
];

$result = $dynamoDB->query($tableName, $keyConditionExpression, $expressionAttributeValues);
print_r($result);
```

3. Customize and extend the wrapper according to your specific needs. The provided code serves as a starting point, and you can modify it to add more functionality or adapt it to your project requirements.

## Contribution

Contributions to DynamoMiniPHP are welcome! If you encounter any issues, have suggestions, or want to add new features, please open an issue or submit a pull request.

## License

DynamoMiniPHP is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

## Disclaimer

DynamoMiniPHP is a community-driven project and is not officially maintained or supported by AWS. Use it at your own risk and make sure to review and adhere to the AWS terms and conditions.
