
        
CREATE TABLE course
(
  course_Id   INT         NOT NULL,
  course_name VARCHAR(50) NULL    ,
  subject_Id  INT         NOT NULL,
  PRIMARY KEY (course_Id)
);

CREATE TABLE department
(
  department_Id   INT          NOT NULL,
  department_name VARCHAR(50)  NULL    ,
  logo            VARCHAR(100) NULL    ,
  course_Id       INT          NOT NULL,
  PRIMARY KEY (department_Id)
);

CREATE TABLE faculty
(
  faculty_Id INT NOT NULL,
  subject_Id INT NOT NULL,
  teacher_Id INT NOT NULL,
  PRIMARY KEY (faculty_Id)
);

CREATE TABLE Grades
(
  Grade_Id   DOUBLE NOT NULL,
  student_Id INT    NULL    ,
  course_Id  INT    NULL    ,
  subject_Id INT    NULL    ,
  prelim     DOUBLE NULL    ,
  midterm    DOUBLE NULL    ,
  semi_final DOUBLE NULL    ,
  final      DOUBLE NULL    ,
  PRIMARY KEY (Grade_Id)
);

CREATE TABLE semester
(
  semester_Id   INT         NOT NULL,
  semester_name VARCHAR(50) NULL    ,
  yearLvl       VARCHAR(50) NULL    ,
  subject_Id    INT         NOT NULL,
  PRIMARY KEY (semester_Id)
);

CREATE TABLE student
(
  student_Id    INT         NOT NULL,
  firstname     VARCHAR(50) NULL    ,
  lastname      VARCHAR(50) NULL    ,
  age           INT         NULL    ,
  gender        VARCHAR(50) NULL    ,
  address       VARCHAR(50) NULL    ,
  contact       VARCHAR(50) NULL    ,
  department_Id INT         NOT NULL,
  yearLvl       VARCHAR(50) NULL    ,
  PRIMARY KEY (student_Id)
);

CREATE TABLE subject
(
  subject_Id   INT         NOT NULL,
  subject_name VARCHAR(50) NULL    ,
  PRIMARY KEY (subject_Id)
);

CREATE TABLE teacher
(
  teacher_Id    INT         NOT NULL,
  firstname     VARCHAR(50) NULL    ,
  lastname      VARCHAR(50) NULL    ,
  age           INT         NULL    ,
  gender        VARCHAR(50) NULL    ,
  address       VARCHAR(50) NULL    ,
  contact       VARCHAR(50) NULL    ,
  department_Id INT         NOT NULL,
  PRIMARY KEY (teacher_Id)
);

ALTER TABLE faculty
  ADD CONSTRAINT FK_subject_TO_faculty
    FOREIGN KEY (subject_Id)
    REFERENCES subject (subject_Id);

ALTER TABLE faculty
  ADD CONSTRAINT FK_teacher_TO_faculty
    FOREIGN KEY (teacher_Id)
    REFERENCES teacher (teacher_Id);

ALTER TABLE department
  ADD CONSTRAINT FK_course_TO_department
    FOREIGN KEY (course_Id)
    REFERENCES course (course_Id);

ALTER TABLE student
  ADD CONSTRAINT FK_department_TO_student
    FOREIGN KEY (department_Id)
    REFERENCES department (department_Id);

ALTER TABLE teacher
  ADD CONSTRAINT FK_department_TO_teacher
    FOREIGN KEY (department_Id)
    REFERENCES department (department_Id);

ALTER TABLE semester
  ADD CONSTRAINT FK_subject_TO_semester
    FOREIGN KEY (subject_Id)
    REFERENCES subject (subject_Id);

ALTER TABLE course
  ADD CONSTRAINT FK_subject_TO_course
    FOREIGN KEY (subject_Id)
    REFERENCES subject (subject_Id);

ALTER TABLE Grades
  ADD CONSTRAINT FK_student_TO_Grades
    FOREIGN KEY (student_Id)
    REFERENCES student (student_Id);

ALTER TABLE Grades
  ADD CONSTRAINT FK_course_TO_Grades
    FOREIGN KEY (course_Id)
    REFERENCES course (course_Id);

ALTER TABLE Grades
  ADD CONSTRAINT FK_subject_TO_Grades
    FOREIGN KEY (subject_Id)
    REFERENCES subject (subject_Id);

        
      
