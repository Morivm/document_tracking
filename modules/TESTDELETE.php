Imports DevComponents.DotNetBar
Imports System.Text.RegularExpressions

Public Class ucViewDoc
    Sub New()

        ' This call is required by the designer.
        InitializeComponent()

        ' Add any initialization after the InitializeComponent() call.
        Dim doc As New DataTable
        Dim filldoctype As New DataTable
        'filldoctype = ExecuteQuery("select doctype_name,doctype_code from dbo.tbl_doctype")
        filldoctype = ExecuteQuery("select * from vw_docType")
        With cbDocType
            .DataSource = filldoctype
            .DisplayMember = filldoctype.Columns(0).ColumnName
            .ValueMember = filldoctype.Columns(1).ColumnName
            .SelectedIndex = -1
        End With

        dgView.DataSource = Nothing
        dgView.AutoGenerateColumns = False
        'doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' order by received_id desc")
        doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "' order by received_id desc")
        dgView.DataSource = doc
        Multi_LineGrid(dgView)
        Dim userSearch As New DataTable

        userSearch = ExecuteQuery("SELECT TOP 1 * from vw_login where UsersName = '" & frmLogin.txtUserName.Text & "' and Password = '" & frmLogin.txtPassword.Text & "'")
        For Each frmDeptItmsub As DevComponents.DotNetBar.ButtonItem In Me.barTool.Items
            userSearch.DefaultView.RowFilter = "btn = '" & frmDeptItmsub.Name & "' and enable = False"
            If userSearch.DefaultView.Count > 0 Then
                frmDeptItmsub.Enabled = False
            End If
        Next
        _turnOn = False
        Me.Timer1.Enabled = True
        Me.Timer1.Start()

    End Sub
    Private Sub btSearch_Click(sender As System.Object, e As System.EventArgs) Handles btSearch.Click
        Dim barcode As String = Nothing
        Dim client As String = Nothing
        Dim title As String = Nothing
        Dim doctype As String = Nothing
        If txBarcode.Text = "" Then
            barcode = "%"
        Else
            barcode = txBarcode.Text
        End If
        If txClient.Text = "" Then
            client = "%"
        Else
            client = txClient.Text
        End If
        If txPTitle.Text = "" Then
            title = "%"
        Else
            title = txPTitle.Text
        End If
        If cbDocType.Text = "" Then
            doctype = "%"
        Else
            doctype = cbDocType.Text
        End If
        'If dgView.RowCount = Nothing Then
        '    Exit Sub
        'End If
        Dim dt As New DataTable
        dgView.DataSource = Nothing

        'dt = ExecuteQuery("SELECT * from vw_search where vw_search.recievedFrom = '" & frmMain.lblUserName.Text & "' and Barcode like '%" & barcode & "%' and Department like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%'  ")
        'dt = ExecuteQuery("SELECT * from vw_doc where vw_doc.recievedFrom = '" & frmMain.lblDeptName.Text & "' and Barcode like '%" & barcode & "%' and RecievedBy like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%' order by received_id desc")
        dt = ExecuteQuery("SELECT * FROM vw_doc where (vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "') and Barcode like '%" & barcode & "%' and RecievedBy like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%' order by received_id desc")
        dgView.DataSource = dt
        dgView.AutoGenerateColumns = False
        Multi_LineGrid(dgView)
    End Sub
    Dim a As String
    Dim b() As String

    Private Sub dgView_CellMouseClick(ByVal sender As Object, ByVal e As System.Windows.Forms.DataGridViewCellMouseEventArgs) Handles dgView.CellMouseClick
        Try
            Dim selectedRow = dgView.CurrentRow.Index
            Dim colName = dgView(8, selectedRow).Value.ToString
            If colName <> "PAUSED" Then
                'Dim dtCheckStat As DataTable = ExecuteQuery("SELECT status FROM tbl_recieved WHERE BARCODE = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id desc")

                '    If dtCheckStat.Rows(0).Item(0).ToString = "PENDING" And dtCheckStat.Rows(0).Item(0).ToString = "" Then
                Dim view As New DataTable
                'view = ExecuteQuery("select *,b.dept_name,c.doctype_name as doctype_name, " & _
                '     "a.ProjectTitle as ProjectTitle from dbo.tbl_recieved a inner join " & _
                '     "dbo.tbl_departments b on a.dept_code = b.dept_code inner join " & _
                '     "dbo.tbl_docType c on a.doctype_code = c.doctype_code where a.barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "'")


                Dim dtGetCreator As DataTable = ExecuteQuery("Select top(1) recievedBy from tbl_recieved where barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id asc")
                Dim dtGetLatestId As DataTable = ExecuteQuery("Select top(1) received_id from tbl_recieved where barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id desc")
                view = ExecuteQuery("select top(1)* from vw_doc where received_id =  '" & dgView.CurrentRow.Cells(13).Value().ToString & "' order by received_id desc ")
                'Dim dtGetAttach As New Odbc.OdbcCommand("Select attachment_name from tbl_attach left join tbl_recieved on tbl_attach.received_id = tbl_recieved.received_id where tbl_recieved.Barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "'", odbcCon)
                'Dim reader As Odbc.OdbcDataReader = dtGetAttach.ExecuteReader()
                'Dim dtGet As DataTable = ExecuteQuery("Select attachment_name from tbl_attach left join tbl_recieved on tbl_attach.received_id = tbl_recieved.received_id where tbl_recieved.Barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "'")
                Dim dtGetAttach As DataTable = ExecuteQuery("Select attachment from tbl_documentMovement  where doc_id = '" & view.Rows(0).Item(0) & "'")
                Dim dtGetNext As DataTable = ExecuteQuery("select TOP(1) dept_name from tbl_receiving_dept where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' and status = 'TURN'")
                If view Is Nothing Then

                    Exit Sub
                End If

                Try
                    lblBarcode.Text = IIf(IsDBNull(view.Rows(0).Item("Barcode")), "", view.Rows(0).Item("Barcode"))
                    lblDocType.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_name")), "", view.Rows(0).Item("doctype_name"))
                    lblDepartment.Text = IIf(IsDBNull(view.Rows(0).Item("dept_name")), "", view.Rows(0).Item("dept_name"))
                    lblClient.Text = IIf(IsDBNull(dtGetNext.Rows(0).Item("dept_name")), "", dtGetNext.Rows(0).Item("dept_name"))
                    lblTitle.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectTitle")), "", view.Rows(0).Item("ProjectTitle"))
                    lblDuration.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectDuration")), "", view.Rows(0).Item("ProjectDuration"))
                    lblStatus.Text = IIf(IsDBNull(view.Rows(0).Item("STATUS")), "", view.Rows(0).Item("STATUS"))
                    'lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectPrice")), "", view.Rows(0).Item("ProjectPrice"))
                    lblPLM.Text = IIf(IsDBNull(view.Rows(0).Item("PLM")), "", view.Rows(0).Item("PLM"))
                    lblBy.Text = IIf(IsDBNull(dtGetCreator.Rows(0).Item("RecievedBy")), "", dtGetCreator.Rows(0).Item("RecievedBy"))
                    lblDate.Text = IIf(IsDBNull(view.Rows(0).Item("recievedDate")), "", view.Rows(0).Item("recievedDate"))
                    lblDescription.Text = IIf(IsDBNull(view.Rows(0).Item("Description")), "", view.Rows(0).Item("Description"))
                    lbRemarks.Text = IIf(IsDBNull(view.Rows(0).Item("remarks")), "", view.Rows(0).Item("remarks"))
                    lsAttachments.Items.Clear()
                    'If reader.HasRows Then
                    '    While reader.Read()
                    '        lsAttachments.Items.Add(reader(0).ToString())
                    '        'btnDownload.Visible = True
                    '    End While
                    'Else
                    '    lsAttachments.Items.Clear()
                    '    'btnDownload.Visible = False
                    'End If
                    Me.tbAttach.Text = dtGetAttach.Rows(0).Item(0).ToString
                Catch ex As Exception
                    MsgBox("No Data to select.", MsgBoxStyle.Information)
                End Try

                Try


                    Dim creator = dgView(4, selectedRow).Value.ToString
                    Dim approved = dgView(13, selectedRow).Value.ToString
                    Dim tos = dgView(5, selectedRow).Value.ToString
                    'Dim colName As String = dgView.Columns(e.ColumnIndex).Name

                    'Dim dtCheckIfForReturn As DataTable = ExecuteQuery("Select barcode from tbl_doc_created where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' and created_status = 'Active'")
                    'If dtCheckIfForReturn.Rows.Count = 0 Then
                    If colName = "PENDING" Then
                        If creator = frmMain.lblDeptName.Text And tos <> String.Empty Then
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = False
                        ElseIf creator = lblDepartment.Text And tos = String.Empty Then
                            Me.btnTransfer.Enabled = True
                            Me.btnApprove.Enabled = True
                            Me.btnReceived.Enabled = False
                        ElseIf creator = frmMain.lblDeptName.Text Then
                            Me.btnTransfer.Enabled = True
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = False
                        ElseIf tos = frmMain.lblDeptName.Text Then
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = True
                        ElseIf tos <> frmMain.lblDeptName.Text Then
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = False
                        End If
                    ElseIf colName = "RECEIVED" Then
                        If frmMain.lblDeptName.Text = lblDepartment.Text And approved = dtGetLatestId.Rows(0).Item(0) And tos = frmMain.lblDeptName.Text Then
                            Me.btnReceived.Enabled = False
                            Me.btnApprove.Enabled = True
                            Me.btnTransfer.Enabled = True
                        ElseIf frmMain.lblDeptName.Text = lblDepartment.Text And approved <> dtGetLatestId.Rows(0).Item(0) Then
                            Me.btnReceived.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnTransfer.Enabled = False
                        ElseIf frmMain.lblDeptName.Text <> lblDepartment.Text And approved <> dtGetLatestId.Rows(0).Item(0) Then
                            Me.btnReceived.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnTransfer.Enabled = False
                        ElseIf frmMain.lblDeptName.Text <> lblDepartment.Text And approved = dtGetLatestId.Rows(0).Item(0) And tos = frmMain.lblDeptName.Text Then
                            Me.btnReceived.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnTransfer.Enabled = True
                        ElseIf frmMain.lblDeptName.Text <> lblDepartment.Text And approved = dtGetLatestId.Rows(0).Item(0) And tos <> frmMain.lblDeptName.Text Then
                            Me.btnReceived.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnTransfer.Enabled = False
                        End If
                    ElseIf colName = "Approved" Then
                        Me.btnTransfer.Enabled = False
                        Me.btnReceived.Enabled = False
                    ElseIf colName = "FORWARDED" Then
                        If tos = frmMain.lblDeptName.Text And approved = dtGetLatestId.Rows(0).Item(0) Then
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = True
                        Else
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = False
                        End If
                    ElseIf colName = "RETURN" Then
                        If tos = frmMain.lblDeptName.Text Then
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = True
                        Else
                            Me.btnTransfer.Enabled = False
                            Me.btnApprove.Enabled = False
                            Me.btnReceived.Enabled = False
                        End If
                    End If
                Catch ex As Exception
                    MsgBox(ex.Message)
                End Try
                '    Else
                'Me.btnTransfer.Enabled = False
                'Me.btnReceived.Enabled = False

                'MessageBoxEx.EnableGlass = False
                'MessageBoxEx.MessageBoxTextColor = Color.Black
                'MessageBoxEx.ButtonsDividerVisible = True

                'MessageBoxEx.Show("Document is at PAUSED State. Click Refresh to check the actual Document Status.", "Error!", MessageBoxButtons.OK, MessageBoxIcon.Error)

                '    End If
            Else
                Me.btnTransfer.Enabled = False
                Me.btnReceived.Enabled = False
            End If
            Me.btnPrint.Enabled = True
            Me.ButtonItem1.Enabled = True
        Catch ex As Exception

        End Try
        
    End Sub

    Private Sub btnPrint_Click(sender As System.Object, e As System.EventArgs) Handles btnPrint.Click
        Dim rReport As New recieve
        Dim dtReport As New DataTable
        'dtReport = ExecuteQuery("select top(1)* from vw_print_report where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' group by received_id ,Description,Barcode,RecievedBy,RecievedFrom,dept_code,doctype_code,plm,ProjectDuration,ProjectPrice,ProjectTitle,recievedDate,Attachments order by received_id asc")
        dtReport = ExecuteQuery("select TOP(1) * from vw_print_report where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id desc")
        If dtReport.Rows.Count > 0 Then
            rReport.SetDataSource(dtReport)
            report.CrystalReportViewer1.ReportSource = rReport
            report.Show()
        End If
    End Sub

    Private Sub ButtonItem1_Click(sender As System.Object, e As System.EventArgs) Handles btnTransfer.Click

        Dim view As New DataTable
        'Dim dtGetAttach As New DataTable

        'view = ExecuteQuery("select *,b.dept_name,c.doctype_name as doctype_name, " & _
        '     "a.ProjectTitle as ProjectTitle from dbo.tbl_recieved a inner join " & _
        '     "dbo.tbl_departments b on a.dept_code = b.dept_code inner join " & _
        '     "dbo.tbl_docType c on a.doctype_code = c.doctype_code where   a.barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "'")
        view = ExecuteQuery("select top(1)* from vw_doc where barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id desc")
        Dim dtDuration As DataTable = ExecuteQuery("select [duration(hrs)] from vw_docType where doctype_name =  '" & view.Rows(0).Item("doctype_name").ToString & "'")
        'dtGetAttach = ExecuteQuery("Select attachment_name from tbl_attach where attach_id = '" & view.Rows(0).Item(0) & "'")
        'Dim dtGetAttach As New Odbc.OdbcCommand("Select attachment_name from tbl_attach where received_id = '" & view.Rows(0).Item(0) & "'", odbcCon)
        'Dim dtGetAttach As New Odbc.OdbcCommand("Select attachment from tbl_documentMovement left join tbl_recieved on tbl_documentMovement.doc_id = tbl_recieved.received_id where tbl_recieved.Barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "'", odbcCon)
        Dim dtGetRemarks As DataTable = ExecuteQuery("Select Remarks from tbl_documentMovement where doc_id = '" & view.Rows(0).Item(0) & "'")
        Dim dtGetCreator As DataTable = ExecuteQuery("Select top(1) recievedBy from tbl_recieved where barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id asc")
        'Dim reader As Odbc.OdbcDataReader = dtGetAttach.ExecuteReader()
        If view.Rows.Count = 0 Then
            Exit Sub
        End If
        Dim dtGetAttach As DataTable = ExecuteQuery("Select attachment from tbl_documentMovement where doc_id = '" & view.Rows(0).Item(0) & "'")
        'If UCase(position) = "PRESIDENT" Then
        '    frmTransfer.btSearch.Text = "APPROVED"
        'Else
        '    frmTransfer.btSearch.Text = "Transfer"
        'End If
        frmTransfer.btSearch.Text = "Transfer"
        frmTransfer.lblBarcode.Text = IIf(IsDBNull(view.Rows(0).Item("Barcode")), "", view.Rows(0).Item("Barcode"))
        frmTransfer.lblDocType.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_name")), "", view.Rows(0).Item("doctype_name"))
        frmTransfer.lblDepartment.Text = IIf(IsDBNull(view.Rows(0).Item("dept_name")), "", view.Rows(0).Item("dept_name"))
        frmTransfer.lblClient.Text = IIf(IsDBNull(view.Rows(0).Item("RecievedFrom")), "", view.Rows(0).Item("RecievedFrom"))
        frmTransfer.lblTitle.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectTitle")), "", view.Rows(0).Item("ProjectTitle"))
        If dtDuration.Rows.Count = 0 Then
            frmTransfer.lblDuration.Text = "72"
        Else
            frmTransfer.lblDuration.Text = IIf(IsDBNull(dtDuration.Rows(0).Item(0)), "", dtDuration.Rows(0).Item(0))
        End If
        frmTransfer.txtDescription.Text = IIf(IsDBNull(view.Rows(0).Item("Description")), "", view.Rows(0).Item("Description"))
        'frmTransfer.lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectPrice")), "", view.Rows(0).Item("ProjectPrice"))
        frmTransfer.lblPLM.Text = IIf(IsDBNull(view.Rows(0).Item("PLM")), "", view.Rows(0).Item("PLM"))
        'frmTransfer.lblBy.Text = IIf(IsDBNull(view.Rows(0).Item("RecievedBy")), "", view.Rows(0).Item("RecievedBy"))
        frmTransfer.lblBy.Text = IIf(IsDBNull(dtGetCreator.Rows(0).Item("RecievedBy")), "", dtGetCreator.Rows(0).Item("RecievedBy"))

        frmTransfer.lblDate.Text = IIf(IsDBNull(view.Rows(0).Item("recievedDate")), "", view.Rows(0).Item("recievedDate"))
        frmTransfer.lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("Due")), "", view.Rows(0).Item("Due"))
        frmTransfer.lbDocTypeCode.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_code")), "", view.Rows(0).Item("doctype_code"))
        frmTransfer.lbDeptCode.Text = IIf(IsDBNull(view.Rows(0).Item("dept_code")), "", view.Rows(0).Item("dept_code"))
        ' frmTransfer.tbAttach.Text = dtGetAttach.Item(0) & Environment.NewLine
        frmTransfer.txtRemarks.Text = IIf(IsDBNull(view.Rows(0).Item("remarks")), "", view.Rows(0).Item("remarks"))

        'lsAttachments.Items.Clear()
        'While reader.Read()
        '    frmTransfer.lsAttachments.Text &= reader(0).ToString() & Environment.NewLine
        'End While

        frmTransfer.tbAttachmentsAttach.Text = dtGetAttach.Rows(0).Item(0).ToString
        'frmTransfer.tbAttachmentsAttach.Text.Replace(",", Environment.NewLine)
        'frmTransfer.tbAttachmentsAttach.Text = Regex.Replace(frmTransfer.tbAttachmentsAttach.Text, ",", vbCrLf)

        'If reader.HasRows Then
        '    While reader.Read()
        '        frmTransfer.ListBox1.Items.Add(reader(0).ToString())
        '        frmTransfer.btnDownload.Visible = True
        '    End While
        'Else
        '    frmTransfer.ListBox1.Items.Clear()
        '    'btnDownload.Visible = False
        'End If

        'If frmMain.lblDeptName.Text = frmTransfer.lblDepartment.Text Then
        '    'frmTransfer.ButtonX1.Visible = False
        '    frmTransfer.Label11.Visible = True
        '    frmTransfer.cbTransferTo.Visible = True
        '    frmTransfer.btSearch.Visible = True
        'Else
        '    'frmTransfer.ButtonX1.Visible = True
        '    frmTransfer.Label11.Visible = False
        '    frmTransfer.cbTransferTo.Visible = False
        '    frmTransfer.btSearch.Visible = False
        'End If

        Dim _username As String = frmMain.lblDeptName.Text
        Dim dtgelastid As DataTable = ExecuteQuery("Select top(1) id from tbl_receiving_dept where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by id desc")
        Dim dtcheckiflast As DataTable = ExecuteQuery("SELECT dept_name,id from tbl_receiving_dept where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' and status = 'TURN'")
        If dtgelastid.Rows(0).Item(0) <> dtcheckiflast.Rows(0).Item(1) Then
            Dim dtgetlastreceiver As DataTable = ExecuteQuery("Select id from tbl_receiving_dept where status = 'TURN' and barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "'")
            Dim next1 As Integer = dtgetlastreceiver.Rows(0).Item(0)
            next1 += 1
            Dim dtgetnext As DataTable = ExecuteQuery("SELECT dept_name from tbl_receiving_dept where barcode = '" & dgView.CurrentRow.Cells(0).Value().ToString & "' and id = '" & next1 & "'")
            frmTransfer.Label11.Text = dtgetnext.Rows(0).Item(0).ToString
        Else
            frmTransfer.Label11.Text = dtcheckiflast.Rows(0).Item(0).ToString
        End If

        frmTransfer.Label11.Visible = False
        frmTransfer.ShowDialog()
        frmTransfer.Dispose()
        dgView.DataSource = Nothing
        dgView.AutoGenerateColumns = False
        Dim doc As New DataTable
        'doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblUserName.Text & "' order by received_id desc")
        doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "' order by received_id desc")
        dgView.DataSource = doc
        Multi_LineGrid(dgView)
        frmMain.btnLogout_Click(Nothing, Nothing)
        Me.btnTransfer.Enabled = False
        Me.btnApprove.Enabled = False

    End Sub

    Private Sub btnReceived_Click(sender As System.Object, e As System.EventArgs) Handles btnReceived.Click

        frmReceive.lbBarcode.Text = dgView.CurrentRow.Cells(0).Value().ToString
        frmReceive.lbStat.Text = dgView.Rows(dgView.CurrentRow.Index).Cells("Stat").Value.ToString
        frmReceive.ShowDialog()
        frmReceive.Dispose()
        Dim doc As New DataTable
        'doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblUserName.Text & "'")
        'doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_name = '" & frmMain.lblDeptName.Text & "' order by received_id desc")
        doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "' order by received_id desc")
        dgView.DataSource = doc
        Multi_LineGrid(dgView)
        Me.btnReceived.Enabled = False
    End Sub

    Private Sub ucViewDoc_Load(sender As System.Object, e As System.EventArgs) Handles MyBase.Load
        Me.dgView.ClearSelection()
    End Sub

    Private Sub btnApprove_Click(sender As System.Object, e As System.EventArgs) Handles btnApprove.Click
        Dim view As New DataTable
        'view = ExecuteQuery("select *,b.dept_name,c.doctype_name as doctype_name, " & _
        '     "a.ProjectTitle as ProjectTitle from dbo.tbl_recieved a inner join " & _
        '     "dbo.tbl_departments b on a.dept_code = b.dept_code inner join " & _
        '     "dbo.tbl_docType c on a.doctype_code = c.doctype_code where   a.barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "'")
        view = ExecuteQuery("select * from vw_doc where barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id desc")
        Dim dtGetCreator As DataTable = ExecuteQuery("Select top(1) recievedBy from tbl_recieved where barcode =  '" & dgView.CurrentRow.Cells(0).Value().ToString & "' order by received_id asc")

        Dim dtDuration As DataTable = ExecuteQuery("select [duration(hrs)] from vw_docType where doctype_name =  '" & view.Rows(0).Item("doctype_name").ToString & "'")
        'dtGetAttach = ExecuteQuery("Select attachment_name from tbl_attach where attach_id = '" & view.Rows(0).Item(0) & "'")
        'Dim dtGetAttach As New Odbc.OdbcCommand("Select attachment_name from tbl_attach where received_id = '" & view.Rows(0).Item(0) & "'", odbcCon)
        Dim dtGetRemarks As DataTable = ExecuteQuery("Select Remarks from tbl_documentMovement where doc_id = '" & view.Rows(0).Item(0) & "'")
        'Dim reader As Odbc.OdbcDataReader = dtGetAttach.ExecuteReader()
        Dim dtGetAttach As DataTable = ExecuteQuery("Select attachment from tbl_documentMovement  where doc_id = '" & view.Rows(0).Item(0) & "'")
        If view Is Nothing Then
            Exit Sub
        End If


        frmApprove.lblBarcode.Text = IIf(IsDBNull(view.Rows(0).Item("Barcode")), "", view.Rows(0).Item("Barcode"))
        frmApprove.lblDocType.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_name")), "", view.Rows(0).Item("doctype_name"))
        frmApprove.lblDepartment.Text = IIf(IsDBNull(view.Rows(0).Item("dept_name")), "", view.Rows(0).Item("dept_name"))
        frmApprove.lblClient.Text = IIf(IsDBNull(view.Rows(0).Item("RecievedFrom")), "", view.Rows(0).Item("RecievedFrom"))
        frmApprove.lblTitle.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectTitle")), "", view.Rows(0).Item("ProjectTitle"))
        If dtDuration.Rows.Count = 0 Then
            frmApprove.lblDuration.Text = "72"
        Else
            frmApprove.lblDuration.Text = IIf(IsDBNull(dtDuration.Rows(0).Item(0)), "", dtDuration.Rows(0).Item(0))
        End If
        'frmApprove.lblDuration.Text = IIf(IsDBNull(dtDuration.Rows(0).Item(0)), "", dtDuration.Rows(0).Item(0))
        frmApprove.txtDescription.Text = IIf(IsDBNull(view.Rows(0).Item("Description")), "", view.Rows(0).Item("Description"))
        'frmTransfer.lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectPrice")), "", view.Rows(0).Item("ProjectPrice"))
        frmApprove.lblPLM.Text = IIf(IsDBNull(view.Rows(0).Item("PLM")), "", view.Rows(0).Item("PLM"))
        'frmTransfer.lblBy.Text = IIf(IsDBNull(view.Rows(0).Item("RecievedBy")), "", view.Rows(0).Item("RecievedBy"))
        frmApprove.lblBy.Text = IIf(IsDBNull(dtGetCreator.Rows(0).Item("RecievedBy")), "", dtGetCreator.Rows(0).Item("RecievedBy"))

        frmApprove.lblDate.Text = IIf(IsDBNull(view.Rows(0).Item("recievedDate")), "", view.Rows(0).Item("recievedDate"))
        frmApprove.lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("Due")), "", view.Rows(0).Item("Due"))
        frmApprove.lbDocTypeCode.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_code")), "", view.Rows(0).Item("doctype_code"))
        frmApprove.lbDeptCode.Text = IIf(IsDBNull(view.Rows(0).Item("dept_code")), "", view.Rows(0).Item("dept_code"))
        ' frmTransfer.tbAttach.Text = dtGetAttach.Item(0) & Environment.NewLine
        frmApprove.txtRemarks.Text = IIf(IsDBNull(dtGetRemarks.Rows(0).Item(0)), "", dtGetRemarks.Rows(0).Item(0))
        frmApprove.tbAttachmentsAttach.Text = dtGetAttach.Rows(0).Item(0).ToString
        'While reader.Read()
        '    frmApprove.tbAttach.Text &= reader(0).ToString() & Environment.NewLine
        'End While

        'frmApprove.lblBarcode.Text = IIf(IsDBNull(view.Rows(0).Item("Barcode")), "", view.Rows(0).Item("Barcode"))
        'frmApprove.lblDocType.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_name")), "", view.Rows(0).Item("doctype_name"))
        'frmApprove.lblDepartment.Text = IIf(IsDBNull(view.Rows(0).Item("dept_name")), "", view.Rows(0).Item("dept_name"))
        'frmApprove.lblClient.Text = IIf(IsDBNull(view.Rows(0).Item("RecievedFrom")), "", view.Rows(0).Item("RecievedFrom"))
        'frmApprove.lblTitle.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectTitle")), "", view.Rows(0).Item("ProjectTitle"))
        'frmApprove.lblDuration.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectDuration")), "", view.Rows(0).Item("ProjectDuration"))
        'frmApprove.txtDescription.Text = IIf(IsDBNull(view.Rows(0).Item("Description")), "", view.Rows(0).Item("Description"))
        ''frmApprove.lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("ProjectPrice")), "", view.Rows(0).Item("ProjectPrice"))
        'frmApprove.lblPLM.Text = IIf(IsDBNull(view.Rows(0).Item("PLM")), "", view.Rows(0).Item("PLM"))
        'frmApprove.lblBy.Text = IIf(IsDBNull(view.Rows(0).Item("RecievedBy")), "", view.Rows(0).Item("RecievedBy"))
        'frmApprove.lblDate.Text = IIf(IsDBNull(view.Rows(0).Item("recievedDate")), "", view.Rows(0).Item("recievedDate"))
        'frmApprove.lblPrice.Text = IIf(IsDBNull(view.Rows(0).Item("Due")), "", view.Rows(0).Item("Due"))
        'frmApprove.lbDocTypeCode.Text = IIf(IsDBNull(view.Rows(0).Item("doctype_code")), "", view.Rows(0).Item("doctype_code"))
        'frmApprove.lbDeptCode.Text = IIf(IsDBNull(view.Rows(0).Item("dept_code")), "", view.Rows(0).Item("dept_code"))
        'Dim a As String
        'Dim b() As String

        'a = IIf(IsDBNull(view.Rows(0).Item("doctype_Attachments")), "", view.Rows(0).Item("doctype_Attachments"))
        'b = a.Split(",")
        'frmApprove.lsAttachments.Items.Clear()
        'For c As Integer = 0 To b.Length - 1
        '    If b(c) = Nothing Then
        '        Continue For
        '    End If
        '    frmApprove.lsAttachments.Items.Add(b(c))
        'Next

        frmApprove.ShowDialog()
        frmApprove.Dispose()
        dgView.DataSource = Nothing
        dgView.AutoGenerateColumns = False
        Dim doc As New DataTable
        'doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblUserName.Text & "' order by received_id desc")
        doc = ExecuteQuery("SELECT * FROM vw_doc where vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "' order by received_id desc")
        dgView.DataSource = doc
        Multi_LineGrid(dgView)
        frmMain.btnLogout_Click(Nothing, Nothing)
        Me.btnApprove.Enabled = False
        Me.btnTransfer.Enabled = False
    End Sub

    Private Sub lsAttachments_DoubleClick(sender As System.Object, e As System.EventArgs) Handles lsAttachments.DoubleClick
        Dim str = lsAttachments.SelectedItem.ToString
        Dim leftPart As String = str.Split(".")(1)
        If leftPart = "jpg" Then
            Dim filename As String = System.IO.Path.Combine(My.Settings.path, lblBarcode.Text + "\" + lsAttachments.SelectedItem.ToString)

            If System.IO.File.Exists(filename) Then
                frmShowDoc.pbFileImage.Image = Image.FromFile(filename)
                'frmShowDoc.lbFileName.Text = lblBarcode.Text + "-" + lsAttachments.SelectedItem.ToString & ".jpg"
                frmShowDoc.ShowDialog()
                frmShowDoc.Dispose()
            End If

        ElseIf leftPart = "pdf" Then
            Dim a As String = lsAttachments.SelectedItem.ToString
            a = Replace(a, vbCrLf, "")
            ''Dim filename As String = System.IO.Path.Combine(My.Settings.path, lblBarcode.Text + "\" + lsAttachments.SelectedItem.ToString)
            'System.Diagnostics.Process.Start(My.Settings.path + lblBarcode.Text + "\" + lsAttachments.SelectedItem.ToString)
            MsgBox(My.Settings.path + lblBarcode.Text + "\" + a)
        End If

    End Sub

    'Private Sub Button1_Click(sender As System.Object, e As System.EventArgs) Handles btnDownload.Click
    '    If (Not System.IO.Directory.Exists(My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text)) Then
    '        System.IO.Directory.CreateDirectory(My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text)
    '    End If
    '    My.Computer.FileSystem.CopyDirectory(My.Settings.path + Me.lblBarcode.Text, My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text, True)
    '    'MsgBox("Download completed at " + My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text)
    '    MessageBoxEx.EnableGlass = False
    '    MessageBoxEx.MessageBoxTextColor = Color.Black
    '    MessageBoxEx.ButtonsDividerVisible = True
    '    MessageBoxEx.Show("Download completed at " + My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text, "", MessageBoxButtons.OK, MessageBoxIcon.Information)
    'End Sub

    'Private Sub ButtonItem1_Click_1(sender As System.Object, e As System.EventArgs) Handles ButtonItem1.Click
    '    Dim dt As New DataTable
    '    dgView.DataSource = Nothing

    '    'dt = ExecuteQuery("SELECT * from vw_search where vw_search.recievedFrom = '" & frmMain.lblUserName.Text & "' and Barcode like '%" & barcode & "%' and Department like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%'  ")
    '    'dt = ExecuteQuery("SELECT * from vw_doc where vw_doc.recievedFrom = '" & frmMain.lblDeptName.Text & "' and Barcode like '%" & barcode & "%' and RecievedBy like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%' order by received_id desc")
    '    dt = ExecuteQuery("SELECT * FROM vw_doc where (vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "') order by received_id desc")
    '    dgView.DataSource = dt
    '    dgView.AutoGenerateColumns = False
    '    Multi_LineGrid(dgView)
    'End Sub



    Private Sub btnDownload_Click(sender As System.Object, e As System.EventArgs)
        If (Not System.IO.Directory.Exists(My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text)) Then
            System.IO.Directory.CreateDirectory(My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text)
        End If
        My.Computer.FileSystem.CopyDirectory(My.Settings.path + Me.lblBarcode.Text, My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text, True)
        'MsgBox("Download completed at " + My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text)
        MessageBoxEx.EnableGlass = False
        MessageBoxEx.MessageBoxTextColor = Color.Black
        MessageBoxEx.ButtonsDividerVisible = True
        MessageBoxEx.Show("Download completed at " + My.Computer.FileSystem.SpecialDirectories.MyDocuments + "\" + Me.lblBarcode.Text, "", MessageBoxButtons.OK, MessageBoxIcon.Information)
    End Sub

    Private Sub ButtonItem1_Click_1(sender As System.Object, e As System.EventArgs) Handles ButtonItem1.Click
        Dim dt As New DataTable
        dgView.DataSource = Nothing

        'dt = ExecuteQuery("SELECT * from vw_search where vw_search.recievedFrom = '" & frmMain.lblUserName.Text & "' and Barcode like '%" & barcode & "%' and Department like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%'  ")
        'dt = ExecuteQuery("SELECT * from vw_doc where vw_doc.recievedFrom = '" & frmMain.lblDeptName.Text & "' and Barcode like '%" & barcode & "%' and RecievedBy like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%' order by received_id desc")
        dt = ExecuteQuery("SELECT * FROM vw_doc where (vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "') order by received_id desc")
        dgView.DataSource = dt
        dgView.AutoGenerateColumns = False
        Multi_LineGrid(dgView)
        Me.btnTransfer.Enabled = False
        Me.btnApprove.Enabled = False
        Me.btnReceived.Enabled = False
        Me.btnPrint.Enabled = False
    End Sub

    Private Sub Timer1_Tick(sender As System.Object, e As System.EventArgs) Handles Timer1.Tick
        If _turnOn = True Then
            Dim dt As New DataTable
            dgView.DataSource = Nothing

            'dt = ExecuteQuery("SELECT * from vw_search where vw_search.recievedFrom = '" & frmMain.lblUserName.Text & "' and Barcode like '%" & barcode & "%' and Department like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%'  ")
            'dt = ExecuteQuery("SELECT * from vw_doc where vw_doc.recievedFrom = '" & frmMain.lblDeptName.Text & "' and Barcode like '%" & barcode & "%' and RecievedBy like '%" & client & "%' and ProjectTitle like '%" & title & "%' and doctype_name like '%" & doctype & "%' order by received_id desc")
            dt = ExecuteQuery("SELECT * FROM vw_doc where (vw_doc.RecievedFrom = '" & frmMain.lblDeptName.Text & "' or vw_doc.froms = '" & frmMain.lblDeptName.Text & "' or vw_doc.dept_code = '" & frmMain.lblDocType.Text & "') order by received_id desc")
            dgView.DataSource = dt
            dgView.AutoGenerateColumns = False
            Multi_LineGrid(dgView)

            Me.btnTransfer.Enabled = False
            Me.btnApprove.Enabled = False
            Me.btnReceived.Enabled = False
            Me.btnPrint.Enabled = False
            _turnOn = False
        End If

    End Sub
End Class



=======================================================================

database

select * from tbl_documentMovement
select * from tbl_receiving_dept
select * from tbl_recieved

truncate table tbl_documentMovement
truncate table tbl_receiving_dept
truncate table tbl_recieved



select * from tbl_departments

select * from tbl_web_setup
select * from tbl_web_setup
SELECT * FROM vw_doc where vw_doc.RecievedFrom = 'Office of the Chief Operating Officer' or vw_doc.froms = 'Office of the Chief Operating Officer' or vw_doc.dept_code = 'OCOO' order by received_id desc



Select top(1) recievedBy from tbl_recieved where barcode =  'OCOOIR20220802344512' order by received_id asc -- CREATOR
Select top(1) received_id from tbl_recieved where barcode =   'OCOOIR20220802344512'  order by received_id desc -- LAST ID
Select attachment from tbl_documentMovement  where doc_id = 1 -- RECEIVED ID
select TOP(1) dept_name from tbl_receiving_dept where barcode = 'OCOOIR20220802344512' and status = 'TURN' -- DEPT NAME



select * from tbl_user

receivedByName


Select dept_code, dept_name from vw_user_info where emp_name ='Reyes, Allan'


SELECT * from vw_login where UsersName = 'ODCOOMPUSER' and Password = HASHBYTES('SHA2_512','4HyDjw9EaL')

select top(1)* from vw_doc where received_id =  1 order by received_id desc 


SELECT *, (Select top(1) received_id from tbl_recieved where barcode ='OCOOIR20220802134713' order by received_id desc) as lastid FROM vw_doc where (vw_doc.RecievedFrom = 'Office of the Chief Operating Officer' or vw_doc.froms = 'Office of the Chief Operating Officer' or vw_doc.dept_code = 'OCOO') and Barcode like '%OCOOIR20220802134713%' and RecievedBy like '%%' and ProjectTitle like '%%' and doctype_name like '%%' order by received_id desc






