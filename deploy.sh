#!/bin/bash

# Set environment variables
export AWS_REGION="your-region"
export APPLICATION_NAME="your-app-name"
export ENVIRONMENT_NAME="your-env-name"
export S3_BUCKET="your-s3-bucket"
export ZIP_FILE="application.zip"

# Zip the application
zip -r $ZIP_FILE . -x "docker-compose.yml" "deploy.sh" ".git/*"

# Upload to S3
aws s3 cp $ZIP_FILE s3://$S3_BUCKET/$ZIP_FILE --region $AWS_REGION

# Create or update Elastic Beanstalk application version
aws elasticbeanstalk create-application-version \
    --application-name $APPLICATION_NAME \
    --version-label $(date +%Y%m%d%H%M%S) \
    --source-bundle S3Bucket=$S3_BUCKET,S3Key=$ZIP_FILE \
    --region $AWS_REGION

# Deploy to Elastic Beanstalk
aws elasticbeanstalk update-environment \
    --environment-name $ENVIRONMENT_NAME \
    --version-label $(date +%Y%m%d%H%M%S) \
    --region $AWS_REGION

# Clean up
rm $ZIP_FILE
