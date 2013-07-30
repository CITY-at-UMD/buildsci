CREATE TABLE [dbo].[auth_users](
	[userid] [varchar](50) NOT NULL,
	[password] [varchar](max) NULL,
 CONSTRAINT [PK_auth_user] PRIMARY KEY ([userid])
)

CREATE TABLE [dbo].[userprofile](
	[userid] [varchar](50) NOT NULL,
	[firstname] [varchar](50) NULL,
	[lastname] [varchar](50) NULL,
	[email] [varchar](50) NULL,
    CONSTRAINT [PK_userprofile] PRIMARY KEY ([userid]),
    CONSTRAINT [FK_auth_user_userprofile] FOREIGN KEY ([userid])
	REFERENCES [dbo].[auth_users]([userid]) 
	ON UPDATE NO ACTION
	ON DELETE CASCADE
)