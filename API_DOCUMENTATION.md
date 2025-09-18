# 📱 Sa7b API Documentation for Flutter Team

## 🔐 Authentication

All student endpoints require authentication. Include the Bearer token in the Authorization header:

```dart
headers: {
  'Authorization': 'Bearer $token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}
```

**Base URL:** `https://your-domain.com/api`

---

## 📋 Table of Contents

1. [Authentication & Registration](#authentication--registration)
2. [Student Account Management](#student-account-management)
3. [Courses & Lectures](#courses--lectures)
4. [File Management](#file-management)
5. [Posts & Social Features](#posts--social-features)
6. [Skills & Certificates](#skills--certificates)
7. [Complaints System](#complaints-system)
8. [Academic Guidance](#academic-guidance)
9. [Feedback System](#feedback-system)
10. [Privacy Settings](#privacy-settings)

---

## 🔐 Authentication & Registration

### 1. Request OTP for Registration
```http
POST /register/otp
```

**Request Body:**
```json
{
  "phone_number": "0938249138"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "OTP sent successfully"
}
```

### 2. Verify OTP for Registration
```http
POST /register/verify
```

**Request Body:**
```json
{
  "phone_number": "0938249138",
  "otp": "123456"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "OTP verified successfully",
  "data": {
    "verification_token": "abc123..."
  }
}
```

### 3. Complete Registration
```http
POST /register/complete
```

**Request Body:**
```json
{
  "verification_token": "abc123...",
  "username": "john_doe",
  "password": "password123",
  "first_name": "John",
  "middle_name": "Michael",
  "last_name": "Doe",
  "college_id": 1,
  "study_year_id": 1,
  "specialization_id": 1
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Registration completed successfully",
  "data": {
    "user": {
      "id": 1,
      "username": "john_doe",
      "token": "bearer_token_here"
    }
  }
}
```

### 4. Login
```http
POST /login
```

**Request Body:**
```json
{
  "username": "john_doe",
  "password": "password123"
}
```

**Response:**
```json
{
  "status": "success",
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "username": "john_doe",
      "token": "bearer_token_here"
    }
  }
}
```

### 5. Logout
```http
POST /student/logout
```

**Headers:** `Authorization: Bearer {token}`

**Response:**
```json
{
  "status": "success",
  "message": "Logged out successfully"
}
```

---

## 👤 Student Account Management

### 1. Get My Account
```http
GET /student/account
```

**Response:**
```json
{
  "status": "success",
  "message": "Account Retrieved Successfully",
  "data": {
    "id": 1,
    "first_name": "John",
    "middle_name": "Michael",
    "last_name": "Doe",
    "username": "john_doe",
    "bio": "Computer Science Student",
    "phone_number": "0938249138",
    "image": "https://yourapp.com/storage/students/profile.jpg",
    "college_name": "College of Engineering",
    "linkedIn_account": "https://linkedin.com/in/johndoe",
    "facebook_account": "https://facebook.com/johndoe",
    "github_account": "https://github.com/johndoe",
    "x_account": "https://x.com/johndoe",
    "skills": [...],
    "academic_year": "2024",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

### 2. Update Account
```http
POST /student/account/update
```

**Request Body (multipart/form-data):**
```json
{
  "first_name": "John",
  "middle_name": "Michael", 
  "last_name": "Doe",
  "bio": "Updated bio",
  "phone_number": "0938249138",
  "image": "file_upload_here",
  "linkedIn_account": "https://linkedin.com/in/johndoe",
  "facebook_account": "https://facebook.com/johndoe",
  "github_account": "https://github.com/johndoe",
  "x_account": "https://x.com/johndoe",
  "skills": ["Flutter", "Dart", "Laravel"],
  "academic_year_id": 2
}
```

### 3. Get Student Account (by ID)
```http
GET /student/account/{student_id}
```

### 4. Delete Account
```http
DELETE /student/account/delete
```

---

## 🎓 Courses & Lectures

### 1. Get All Courses
```http
GET /student/courses
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Introduction to Programming",
      "description": "Learn the basics of programming",
      "college_id": 1,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

### 2. Get My Enrolled Courses
```http
GET /student/courses/my-courses
```

### 3. Get Course Details
```http
GET /student/courses/{course_id}
```

### 4. Get Course Lectures
```http
GET /student/courses/{course_id}/lectures
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Introduction to Variables",
      "content": "Lecture content here...",
      "course_id": 1,
      "academic_year_id": 1,
      "student_id": 1,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

### 5. Get Course Slides
```http
GET /student/courses/{course_id}/slides
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Lecture 1 Slides",
      "content": "lecture_slides/slide1.pdf",
      "download_url": "https://yourapp.com/storage/lecture_slides/slide1.pdf",
      "file_type": "pdf",
      "lecture_id": 1,
      "created_at": "2024-01-01 10:30:00",
      "updated_at": "2024-01-01 10:30:00"
    }
  ]
}
```

### 6. Get Course Audios
```http
GET /student/courses/{course_id}/audios
```

### 7. Get Course Summaries
```http
GET /student/courses/{course_id}/summaries
```

### 8. Get Course Academic Guidance
```http
GET /student/courses/{course_id}/academic-guidance
```

### 9. Get Course Announcements
```http
GET /student/courses/{course_id}/announcements
```

---

## 📁 File Management

### Individual File Details

#### 1. Get Slide Details
```http
GET /student/files/slides/{slide_id}
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "title": "Lecture 1 Slides",
    "content": "lecture_slides/slide1.pdf",
    "download_url": "https://yourapp.com/storage/lecture_slides/slide1.pdf",
    "file_type": "pdf",
    "lecture_id": 1,
    "lecture_title": "Introduction to Variables",
    "created_at": "2024-01-01 10:30:00",
    "updated_at": "2024-01-01 10:30:00"
  }
}
```

#### 2. Get Audio Details
```http
GET /student/files/audios/{audio_id}
```

#### 3. Get Summary Details
```http
GET /student/files/summaries/{summary_id}
```

### File Downloads

#### 1. Download Slide
```http
GET /student/files/slides/{slide_id}/download
```

**Response:** Binary file download

#### 2. Download Audio
```http
GET /student/files/audios/{audio_id}/download
```

#### 3. Download Summary
```http
GET /student/files/summaries/{summary_id}/download
```

### File Uploads

#### 1. Upload Slides
```http
POST /student/lectures/{lecture_id}/upload/slides
```

**Request Body (multipart/form-data):**
```json
{
  "title": "Lecture 5 Slides",
  "slides": ["file1.pdf", "file2.pptx"]
}
```

**File Types:** PDF, PPT, PPTX, DOC, DOCX, JPG, JPEG, PNG  
**Max Files:** 10  
**Max Size:** 10MB each

#### 2. Upload Audios
```http
POST /student/lectures/{lecture_id}/upload/audios
```

**Request Body (multipart/form-data):**
```json
{
  "title": "Lecture 5 Audio",
  "audios": ["lecture.mp3", "notes.wav"]
}
```

**File Types:** MP3, WAV, M4A, AAC, OGG  
**Max Files:** 5  
**Max Size:** 50MB each

#### 3. Upload Summaries
```http
POST /student/lectures/{lecture_id}/upload/summaries
```

**File Types:** PDF, DOC, DOCX, TXT  
**Max Files:** 5  
**Max Size:** 10MB each

#### 4. Upload Handouts
```http
POST /student/lectures/{lecture_id}/upload/handouts
```

**File Types:** PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT  
**Max Files:** 10  
**Max Size:** 10MB each

### File Deletion

#### 1. Delete Slide
```http
DELETE /student/lectures/slides/{slide_id}
```

#### 2. Delete Audio
```http
DELETE /student/lectures/audios/{audio_id}
```

#### 3. Delete Summary
```http
DELETE /student/lectures/summaries/{summary_id}
```

#### 4. Delete Handout
```http
DELETE /student/lectures/handouts/{handout_id}
```

---

## 📝 Posts & Social Features

### 1. Get All Posts
```http
GET /student/posts
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "My First Post",
      "description": "This is my first post content",
      "visibility": "public",
      "student_id": 1,
      "files": [
        {
          "id": 1,
          "file": "posts/file1.pdf",
          "download_url": "https://yourapp.com/storage/posts/file1.pdf"
        }
      ],
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

### 2. Get Post Details
```http
GET /student/posts/{post_id}
```

### 3. Create Post
```http
POST /student/posts
```

**Request Body (multipart/form-data):**
```json
{
  "title": "My New Post",
  "description": "Post content here",
  "visibility": "public",
  "files": ["file1.pdf", "file2.jpg"]
}
```

### 4. Update Post
```http
POST /student/posts/{post_id}
```

### 5. Delete Post
```http
DELETE /student/posts/{post_id}
```

### Follow System

#### 1. Get Followers
```http
GET /student/followers
```

#### 2. Get Following
```http
GET /student/followers/following
```

#### 3. Follow Student
```http
POST /student/followers/{student_id}/follow
```

#### 4. Unfollow Student
```http
POST /student/followers/{student_id}/unfollow
```

---

## 🎯 Skills & Certificates

### Skills Management

#### 1. Get All Skills
```http
GET /student/skills
```

#### 2. Get My Skills
```http
GET /student/skills/my-skills
```

#### 3. Get Student Skills
```http
GET /student/skills/students/{student_id}
```

#### 4. Add Skill
```http
POST /student/skills
```

**Request Body:**
```json
{
  "skill": "Flutter Development"
}
```

#### 5. Delete Skill
```http
DELETE /student/skills/{skill_id}
```

### Certificates Management

#### 1. Get My Certificates
```http
GET /student/certificates
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Flutter Development Certificate",
      "description": "Completed Flutter course",
      "file": "certificates/cert1.pdf",
      "download_url": "https://yourapp.com/storage/certificates/cert1.pdf",
      "student_id": 1,
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

#### 2. Get Student Certificates
```http
GET /student/certificates/{student_id}/student
```

#### 3. Add Certificate
```http
POST /student/certificates
```

**Request Body (multipart/form-data):**
```json
{
  "title": "New Certificate",
  "description": "Certificate description",
  "file": "certificate_file.pdf"
}
```

#### 4. Delete Certificate
```http
DELETE /student/certificates/{certificate_id}
```

---

## 🚨 Complaints System

### 1. Get My Complaints
```http
GET /student/complaints
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Issue with Course Material",
      "description": "The course material is not accessible",
      "type": {
        "id": 1,
        "type": "Technical Issue"
      },
      "files": [
        {
          "id": 1,
          "image": "https://yourapp.com/storage/complaint_files/screenshot.jpg"
        }
      ],
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

### 2. Get Complaint Types
```http
GET /student/complaints/types
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "type": "Technical Issue"
    },
    {
      "id": 2,
      "type": "Academic Concern"
    }
  ]
}
```

### 3. Get Complaint Details
```http
GET /student/complaints/{complaint_id}
```

### 4. Submit Complaint
```http
POST /student/complaints/send
```

**Request Body (multipart/form-data):**
```json
{
  "title": "Complaint Title",
  "description": "Detailed description of the issue",
  "type_id": 1,
  "images": ["screenshot1.jpg", "screenshot2.png"]
}
```

**File Types:** JPEG, PNG, JPG, GIF  
**Max Files:** 5  
**Max Size:** 5MB each

### 5. Update Complaint
```http
PUT /student/complaints/{complaint_id}
```

### 6. Delete Complaint
```http
DELETE /student/complaints/{complaint_id}
```

---

## 🎓 Academic Guidance

### 1. Get All Academic Guidance
```http
GET /student/academic-guidance
```

### 2. Create Academic Guidance
```http
POST /student/academic-guidance
```

### 3. Update Academic Guidance
```http
POST /student/academic-guidance/{guidance_id}
```

### 4. Delete Academic Guidance
```http
DELETE /student/academic-guidance/{guidance_id}
```

### 5. Get Course Academic Guidance
```http
GET /student/academic-guidance/course/{course_id}
```

### 6. Filter by Type
```http
POST /student/academic-guidance/filter/type
```

### 7. Filter by Date
```http
POST /student/academic-guidance/filter/date
```

### 8. Vote on Academic Guidance
```http
POST /student/academic-guidance/{guidance_id}/vote
```

### 9. Get Vote Statistics
```http
GET /student/academic-guidance/{guidance_id}/vote-stats
```

---

## 📊 Feedback System

### 1. Get Course Feedback
```http
GET /student/feedbacks/course/{course_id}
```

### 2. Get Feedback Details
```http
GET /student/feedbacks/{feedback_id}
```

### 3. Submit Feedback
```http
POST /student/feedbacks/{feedback_id}/submit
```

---

## 🔒 Privacy Settings

### 1. Get Privacy Settings
```http
GET /student/privacy
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "profile_visibility": "public",
    "contact_visibility": "private",
    "academic_info_visibility": "public",
    "created_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

### 2. Update Privacy Settings
```http
PATCH /student/privacy
```

**Request Body:**
```json
{
  "profile_visibility": "public",
  "contact_visibility": "private",
  "academic_info_visibility": "public"
}
```

---

## 🔍 Search

### 1. Search Student Accounts
```http
GET /student/search
```

**Query Parameters:**
- `q`: Search query
- `page`: Page number (optional)

---

## 🏫 Universities & Colleges

### 1. Get Universities
```http
GET /student/universities
```

### 2. Get University Details
```http
GET /student/universities/{university_id}
```

### 3. Get University Colleges
```http
GET /student/universities/{university_id}/colleges
```

### 4. Get College Details
```http
GET /student/colleges/{college_id}
```

### 5. Get College Courses
```http
GET /college/{college_id}/courses
```

---

## 📝 Registration Data

### 1. Get Colleges for Registration
```http
GET /register/colleges
```

### 2. Get Courses for Registration
```http
GET /register/courses
```

### 3. Get Study Years for Registration
```http
GET /register/study-years
```

### 4. Get Specializations for Registration
```http
GET /register/specializations
```

---

## 🚨 Error Handling

### Common Error Responses

#### 401 Unauthorized
```json
{
  "status": "error",
  "message": "Unauthenticated"
}
```

#### 403 Forbidden
```json
{
  "status": "error",
  "message": "Unauthorized",
  "details": "You are not enrolled in this course"
}
```

#### 404 Not Found
```json
{
  "status": "error",
  "message": "Resource not found"
}
```

#### 422 Validation Error
```json
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required"],
    "email": ["The email must be a valid email address"]
  }
}
```

#### 500 Server Error
```json
{
  "status": "error",
  "message": "Internal server error"
}
```

---

## 📱 Flutter Integration Examples

### 1. Authentication Service
```dart
class AuthService {
  static const String baseUrl = 'https://yourapp.com/api';
  
  static Future<Map<String, dynamic>> login(String username, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json'},
      body: json.encode({
        'username': username,
        'password': password,
      }),
    );
    
    return json.decode(response.body);
  }
  
  static Future<Map<String, dynamic>> getAccount(String token) async {
    final response = await http.get(
      Uri.parse('$baseUrl/student/account'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    
    return json.decode(response.body);
  }
}
```

### 2. File Download Service
```dart
class FileService {
  static Future<void> downloadFile(String downloadUrl, String fileName) async {
    final response = await http.get(Uri.parse(downloadUrl));
    
    if (response.statusCode == 200) {
      final directory = await getApplicationDocumentsDirectory();
      final file = File('${directory.path}/$fileName');
      await file.writeAsBytes(response.bodyBytes);
    }
  }
}
```

### 3. File Upload Service
```dart
class UploadService {
  static Future<Map<String, dynamic>> uploadSlides(
    String token,
    int lectureId,
    List<File> files,
    String title,
  ) async {
    var request = http.MultipartRequest(
      'POST',
      Uri.parse('$baseUrl/student/lectures/$lectureId/upload/slides'),
    );
    
    request.headers['Authorization'] = 'Bearer $token';
    request.fields['title'] = title;
    
    for (var file in files) {
      request.files.add(await http.MultipartFile.fromPath('slides[]', file.path));
    }
    
    final response = await request.send();
    final responseBody = await response.stream.bytesToString();
    
    return json.decode(responseBody);
  }
}
```

---

## 📋 Quick Reference

### Base URL
```
https://your-domain.com/api
```

### Authentication Header
```
Authorization: Bearer {token}
```

### Content Types
- **JSON:** `application/json`
- **File Upload:** `multipart/form-data`

### Common Response Format
```json
{
  "status": "success|error",
  "message": "Response message",
  "data": {...}
}
```

---

## 🆘 Support

For technical support or questions about the API, please contact the development team.

**Last Updated:** January 2024  
**API Version:** 2.0
