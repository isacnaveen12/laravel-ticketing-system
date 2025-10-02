## Problem
The current interactive analysis implementation in `intractive_anaysis.py` relies mainly on hardcoded logic and pattern matching, rather than leveraging the LLM with a real prompt and live data context. This limits the flexibility and analytical power of the endpoint, making it difficult to handle nuanced or novel user questions about the sales data.

### Current Issues:
- The `handle_comprehensive_analysis_patterns()` function uses hardcoded pattern matching that takes priority over LLM analysis
- Real user prompts are not being processed correctly by the LLM (Llama 3.1 70B)
- The system is not adapting to actual data structure and content dynamically
- Pattern matching is too aggressive and prevents nuanced query handling

### Current Behavior:
```python
# Pattern matching takes priority (Line ~340)
pattern_result = handle_comprehensive_analysis_patterns(user_question, last_df.copy(), current_context)

if pattern_result:
    # Hardcoded logic executed
    return jsonify(pattern_result)
    
# LLM only used as fallback
```

## Expected Behavior
- The system should prioritize using the LLM (Llama 3.1 70B) to understand user questions in context of actual data
- Should dynamically generate pandas code based on real data structure
- Should handle diverse questions without requiring hardcoded patterns
- LLM should have full visibility of the data schema and be able to reason about it

## Proposed Solution

### 1. Enhance LLM Prompt with Real Data Context
Update `INTERACTIVE_ANALYSIS_PROMPT` to include:
- Actual DataFrame schema (columns, dtypes, sample values)
- Data statistics (row count, date range, unique values)
- Sample records (first 5-10 rows)

### 2. Reorder Analysis Flow Priority
```python
# PROPOSED: LLM first, patterns as fallback
llm_response = await fetch_llm_sql(enhanced_prompt, model)

if llm_response and is_valid_analysis(llm_response):
    # Use LLM-generated analysis
    return process_llm_analysis(llm_response)
else:
    # Fallback to pattern matching
    return handle_comprehensive_analysis_patterns(...)
```

### 3. Improve Data Context Passing
Add function to generate data profile:
```python
def generate_data_profile(df):
    profile = {
        'columns': df.dtypes.to_dict(),
        'row_count': len(df),
        'sample_data': df.head(5).to_dict('records'),
        'numeric_columns': df.select_dtypes(include=[np.number]).columns.tolist(),
        'date_columns': [col for col in df.columns if 'date' in col.lower()],
        'unique_counts': {col: df[col].nunique() for col in df.columns}
    }
    return profile
```

### 4. Enhanced Prompt Template
```python
ENHANCED_PROMPT = """
You are analyzing real sales data with the following structure:

**Available Columns:**
{column_info}

**Data Sample (first 5 records):**
{sample_data}

**Data Statistics:**
- Total records: {total_records}
- Date range: {date_range}
- Unique customers: {unique_customers}
- Unique products: {unique_products}

**User Question:** {user_query}

Generate pandas code to analyze this REAL data and answer the question...
"""
```

### 5. Better JSON Parsing & Error Handling
- Improve `clean_and_fix_json()` function
- Add validation for LLM responses before execution
- Provide meaningful error messages when LLM fails

## Files to Modify

### `intractive_anaysis.py`
- [ ] Line ~340: Reorder analysis flow to prioritize LLM
- [ ] Line ~20-80: Enhance `INTERACTIVE_ANALYSIS_PROMPT` with data context
- [ ] Add new function: `generate_data_profile(df)`
- [ ] Line ~230: Improve `clean_and_fix_json()` robustness
- [ ] Line ~450-550: Update `async_interactive_analysis()` flow

## Acceptance Criteria
- [ ] LLM receives actual data schema and sample in every request
- [ ] Pattern matching only triggers when LLM fails or returns invalid response
- [ ] System can handle novel questions not covered by hardcoded patterns
- [ ] Data profile generation is performant (< 100ms for typical datasets)
- [ ] JSON parsing success rate > 95% for LLM responses
- [ ] All existing tests pass
- [ ] New integration tests added for LLM-first flow

## Testing Plan
1. Test with simple queries: "Show me total sales"
2. Test with complex queries: "Which products have declining sales in the last 3 months?"
3. Test with novel queries not in pattern matching
4. Test error handling when LLM returns invalid JSON
5. Performance test with large datasets (>100k rows)

## Priority
**High** - This blocks the system from being truly dynamic and responsive to real user needs

## Additional Context
- Current date: 2025-10-02
- Reported by: @isacnaveen12
- Related file: `intractive_anaysis.py` (note: filename has typo - should be `interactive_analysis.py`)

Labels: bug, enhancement, llm, priority-high