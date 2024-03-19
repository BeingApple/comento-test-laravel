## 과제에 대하여

우선, 공들여 낸 채용 과제를 보내주셔서 감사드립니다. 지원자의 여러 면모를 자세히 확인해보고 싶다는 바가 느껴지는 성의 있는 채용과제라고 느꼈습니다. 

너무나 오랜만의 라라벨과 PHP여서 그런지 스스로 판단하기에 그리 만족스러운 결과물을 만들진 못했고, 제 숙련도가 좀 더 좋아서 시간이 넉넉했더라면 README 파일이나 주석도 좀 더 신경써서 작성하고 테스트 케이스와 API 명세도 모두 추가하고 싶었지만 아쉽게도 그러지 못했습니다. 그래도 좋은 기회였고, 좋은 경험이었습니다. 다시 한번 기분 좋은 채용과제를 보내주셔서 감사드립니다.

프로젝트 지시서에서 MVP를 MVC로 잘못 읽는 실수를 해서 User-Social처럼 Model을 잘게 쪼개고 관계 정의까지 하고 Category도 동일하게 작업하려는 찰나에 MVP임을 확인하고 황급히 좀 더 유연하게 대응 가능한 형태로 변경했습니다. 제 실수입니다.

미완성이라 슬픈 API 명세는 Swagger 와 OpenApi를 통해 작성되었습니다.
- **[미완성이라 슬픈 API 명세 http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)**

## 인증 과정

인증 과정은 다음 라이브러리를 활용해 구현되었습니다. 

- **laravel/socialite**
- **socialiteproviders/kakao**
- **tymon/jwt-auth**

로그인이 완료되면 코멘토 홈페이지로 이동됩니다. 프론트엔드와 사전 협의하여 발급된 Access Token 을 취급할 수 있는 페이지에 반환하면 됩니다.

![카카오 로그인 화면](https://github.com/BeingApple/comento-test-laravel/assets/21231415/36bd335d-106a-415a-9832-b58e150aa44f)
![개인정보 제공 동의 화면](https://github.com/BeingApple/comento-test-laravel/assets/21231415/3b52d9d4-bcf8-43a8-83bf-1a080d1a0fe1)

## 제공되는 API 목록
- **GET /social/{type}/login** 
- **GET /social/{type}/callback**
- **POST /logout** Bearer 인증 필요
- **POST /refresh** Bearer 인증 필요
- **PUT /user/me** Bearer 인증 필요
- **PUT /user/me/type** Bearer 인증 필요
- **GET /question**
- **POST /question** Bearer 인증 필요
- **GET /question/{id}**
- **DELETE /question/{id}** Bearer 인증 필요
- **POST /question/{id}/answer** Bearer 인증 필요
- **PUT /question/{question_id}/answer/{answer_id}/choose** Bearer 인증 필요
- **DELETE /question/{question_id}/answer/{answer_id}** Bearer 인증 필요

## 어려움을 겪은 것들

- VSCode 를 통해 작업을 진행했는데 주로 사용하던 IntelliJ와 비교해 저를 좀 힘들게 했습니다. 파일명에 모르고 공백을 넣어서 에러가 나는데 이걸 찾는데 한참 시간을 썼던 거 같습니다. 또 참조나 정의로 이동하는 것도 좀 애매했습니다. 라라벨에 좋은 IDE가 있으려나요?
- Pagination 은 Laravel 내부적으로 어떻게 동작하는지 이게 왜 되는지 좀 신기합니다. 저는 별도로 페이징 메소드에 필요한 쿼리 파라메터나 Request 객체를 넘기지 않았는데 귀신같이 page 쿼리 파라메터를 가져다 쓰더군요. 이런 경우 보통 해당 메소드를 제공하는 클래스를 분석해보거나 인터넷에서 명세서를 확인해 보는데 제 검색력이 부족했는지 마땅한 결과물을 찾기가 어려웠습니다.